FROM php:7.3-apache

RUN apt-get update
RUN apt-get install nano


#To keep the size down there are a number of extensions missing. This install mysqli.
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

#Decided to go with volumes for updating simplicity.
#COPY ./Website/ /var/www

EXPOSE 80

#docker build -t thiru .
#docker run -t -d -p 80:80 --restart unless-stopped --name wbsite -v /home/ubuntu/WaterBillSite/Website:/var/www/ thiru 

#Use this one if you want to have a stand alone image with the files copied over.
#docker run --restart unless-stopped --name wbsite -t -d -p 80:80 thiru