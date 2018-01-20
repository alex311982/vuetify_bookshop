#!/bin/bash

# Apache Setup
cp /etc/apache2/apache2.conf /etc/apache2/apache2.conf.backup
cd /etc/apache2/sites-available/

# Define virtualhosts

for i in `seq 1 30`
do
  Q="SITE$i"
  eval "SITENDX=\${$Q}"
  if [ "$SITENDX" ];
  	then
  	  echo "setting virtualhost $SITENDX .. "
  	  cp /etc/apache2/sites-available/virtualhost.template ${SITENDX}.conf
  	  sed -ri -e "s/SERVERNAME/${SITENDX}/" /etc/apache2/sites-available/${SITENDX}.conf
  	  a2ensite ${SITENDX}.conf
  	  [ -d /var/www/${SITENDX} ] || mkdir -p /var/www/html/${SITENDX}
  	  [ -d /var/www/${SITENDX}/www ] || mkdir -p /var/www/html/${SITENDX}/www
      if [ "$SITE" == "$SITENDX" ];
        then
          sed -ri -e "s/SERVERALIAS/www.${SITENDX} \*/" /etc/apache2/sites-available/${SITENDX}.conf
        else
          sed -ri -e "s/SERVERALIAS/www.${SITENDX}/"   /etc/apache2/sites-available/${SITENDX}.conf
      fi
  fi
done