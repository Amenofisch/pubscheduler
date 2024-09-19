FROM webdevops/php-apache-dev:8.3

# Get composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN /usr/local/bin/composer selfupdate

# configure services
RUN set -x \
    && apt-get -q update \
    && apt-get -yq install ca-certificates curl gnupg \
    && docker-service enable syslog \
    && docker-service enable postfix \
    && docker-run-bootstrap \
    && docker-image-cleanup

WORKDIR /app

ARG UID
ARG GID
# Fix application uid/gid by given arguments
RUN echo "Change uid/gid of 'application' user (${UID}:${GID})" && \
    usermod -u ${UID} application && \
    groupmod -g ${GID} application && \
    usermod -g ${GID} application &&     \
    chown "$APPLICATION_USER":"$APPLICATION_GROUP" -R /app /home/application
