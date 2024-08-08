# vehicle-rental-management-system

## Metryki Prometheus

Załaduj dane dla tej migracji bazy danych

``
$ cat backup.sql | docker exec -i vehicle-rental-management-system-mysql-dev /usr/bin/mysql -u root vehicle-rental-management-system_dev
``

Pliki do przeglądu:
- **config/package/prometheus_metrics.yaml** - plik z konfiguracją paczki [prometheus-metrics-bundle](https://github.com/artprima/prometheus-metrics-bundle)
- **config/routes.yaml** - dodano ruting z default metrykami
- **prometheus/** - znajduje się tam plik Dockerfile i plik z danymi do scrapowania dla prometheusa
- **mtail/** - znajduje się tam plik Dockerfile plik wykonawczy oraz application_logs.mtail z danymi dla mtail jakiś słów kluczowych ma wyszukiwac w logach. Przy znalezieniu patternu zmienne są zwiększane.
- pliki **docker-compose.yaml i docker-compose-dev.yaml** - dodano nowe kontenery z Prometheus, Redis, Grafana, Mtail.
- **BrandRepository** - zmiany, które logują do dziennika flagę, której Mtail nasłuchuje.
- **BrandController** - zmiany, które tworzą metryki za pomocą CollectorRegistry.
- **LegacyMetricsController** - klasa, która zwraca legacy metryki.
- **config/services.yaml** - dodanie Registry Collectora.
- Wszystkie metryki przechowywane w bazie REDIS

### Version 1

W LegacyMetricsController stwrzono [endpoint](http://localhost:8083/legacy/metrics)  z metrykami z wczytywanymi przez prometheusa.

Sprawdź plik **./prometheus/prometheus.yml** linia 19-23 plik jest przekazywany do kontrolera **./prometheus/Dockerfile** **fragment : "--config.file=/etc/prometheus/prometheus.yml"**

Dalej Prometheus tworzy grafy. [LINK](http://localhost:9090/graph?g0.expr=count_vehicle_brand&g0.tab=0&g0.stacked=0&g0.show_exemplars=0&g0.range_input=1m)

Zastrzeżenia i wady

- ta metoda może powodować problemy z wydajnością w zależności od zapytań SQL (nie napotkałem takich problemów, ale jest to możliwe)
- nie ma prostego sposobu na zachowanie stanu pomiędzy żądaniami (np. aby pokazać całkowitą liczbę żądań lub logowań w czasie)

### Version 2

W BrandRepository dodano logger linia (25-31) , który loguje do pliku var/log.

W folderze **./mtail** znajduje się folder, który zawiera DockerFile
oraz plik **application_logs.mtail** z konfiguracją mtail.

mtail to narzędzie do monitorowania plików logów, które pozwala na analizowanie logów w czasie rzeczywistym i generowanie metryk na podstawie niestandardowych reguł zapisanych w skryptach.

counter brand_total
counter error_total

counter to typ metryki używany w mtail, który reprezentuje licznik rosnący.

brand_total i error_total to nazwy tych liczników

Każda reguła składa się z wyrażenia regularnego oraz bloku kodu, który zostanie wykonany, jeśli dany wzorzec zostanie znaleziony w logach.

/request\.ERROR/ { error_total++ }:

Wyrażenie regularne /request\.ERROR/ szuka w logach linii zawierających dokładnie frazę request.ERROR.
Jeśli taka linia zostanie znaleziona, licznik error_total zostanie zwiększony o 1 (error_total++).

/Created brand/ { brand_total++ }:

Wyrażenie regularne /Created brand/ szuka w logach linii zawierających frazę Created brand.
Jeśli taka linia zostanie znaleziona, licznik brand_total zostanie zwiększony o 1 (brand_total++).

[LINK](http://localhost:3903/metrics)

Zastrzeżenia i wady

- Symfony używa obsługi fingers_crossed dla monologu w środowisku produkcyjnym, a logi na poziomie informacji nie będą w większości przypadków zapisywane w plikach; aby wyodrębnić metryki z logów, należy zapisać wszystkie odpowiednie logi do pliku
- w niektórych systemach, w których pliki dziennika są zastępowane przez zewnętrzne narzędzie, mtail jest zdezorientowany i ponownie odczytuje dzienniki, mnożąc metryki. Nie powinno to być problemem w produkcji, ale może być problemem podczas korzystania z docker-sync na MacOS
- mtail wymaga, aby pliki dziennika były faktycznie dostępne i możliwe do odczytania w formie plików (np. jeśli wysyłasz swoje dzienniki do Papertrail, musisz zachować plik dla mtail)
- mtail nie ma wbudowanego mechanizmu autoryzacji, więc powinien być uruchomiony w sieci prywatnej lub obsługiwany przez serwer proxy Nginx lub inny serwer WWW z SSL i czymś w rodzaju podstawowego uwierzytelniania

### Version 3 (Best)

Rejestrujemy w **service.yaml** CollectorRegistry, a nastepnie w **BrandController** linia (41-50)
wykonujemy metodę getOrRegisterCounter.

Wynik naszego działania będzie widoczy w default metrics [LINK](http://localhost:8083/metrics/prometheus)

### Grafana

Aby rejestrować materyki za pomocą grafany należy je zarejestrować

Kroki:
- Przekdz do Grafany [LINK](ocalhost:3000)
- Zalguj sie. Default admin pass: admin admin
- Data sources -> Add data source -> prometheus
- Ustaw connection na :http://vehicle-rental-management-system-prometheus-dev:9090
- Save & test

Aby dodać dashboard:
- Dashboard - new -> add visualization -> prometheus
- Wybierz metrykę w Metric
- Run Queries
- Save