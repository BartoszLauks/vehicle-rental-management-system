FROM alpine:latest

# Instalacja curl, bash, i innych narzędzi
RUN apk update && apk add --no-cache curl bash

# Pobranie Prometheus
RUN wget -O /tmp/prometheus.tar.gz https://github.com/prometheus/prometheus/releases/download/v2.44.0/prometheus-2.44.0.linux-amd64.tar.gz || { echo 'Failed to download Prometheus'; exit 1; }

# Rozpakowanie pliku
RUN tar -xzf /tmp/prometheus.tar.gz -C /tmp || { echo 'Failed to extract Prometheus'; exit 1; }

# Przeniesienie plików do odpowiedniego katalogu
RUN mv /tmp/prometheus-2.44.0.linux-amd64 /etc/prometheus || { echo 'Failed to move Prometheus files'; exit 1; }

# Usunięcie istniejącego linku lub pliku, jeśli istnieje, i utworzenie nowego linku symbolicznego
RUN rm -f /usr/local/bin/prometheus && ln -s /etc/prometheus/prometheus /usr/local/bin/prometheus || { echo 'Failed to create symbolic link'; exit 1; }

# Usunięcie pobranego archiwum
RUN rm /tmp/prometheus.tar.gz || { echo 'Failed to remove downloaded archive'; exit 1; }

# Kopiowanie pliku konfiguracyjnego do obrazu
COPY prometheus.yml /etc/prometheus/prometheus.yml

EXPOSE 9090

CMD ["/usr/local/bin/prometheus", "--config.file=/etc/prometheus/prometheus.yml"]
