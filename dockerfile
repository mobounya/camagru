FROM mattrayner/lamp:latest-1804

RUN apt update -y
RUN DEBIAN_FRONTEND=noninteractive apt install -y build-essential software-properties-common
RUN DEBIAN_FRONTEND=noninteractiv apt install -y libsqlite3-dev
RUN DEBIAN_FRONTEND=noninteractive apt install -y ruby-dev ruby
RUN gem install mailcatcher

COPY ./createssl.sh /
RUN [ "bash", "/createssl.sh" ]
