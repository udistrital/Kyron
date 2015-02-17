cd /usr/eclipse
./eclipse &
pgadmin3 &
firefox &
/usr/local/apache/bin/apachectl restart
rm -rf /var/run/postgresql
mkdir /var/run/postgresql
chown -R postgres:postgres /var/run/postgresql
ln -s /tmp/.s.PGSQL.5432 /var/run/postgresql/.s.PGSQL.5432
ln -s /var/run/postgresql/.s.PGSQL.5432 /tmp/.s.PGSQL.5432
su - postgres



