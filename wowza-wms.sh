#!/bin/sh

# NOTE: Here you can configure the JVM's built in JMX interface.
# See the "Server Management Console and Monitoring" chapter
# of the "User's Guide" for more information on how to configure the
# remote JMX interface in the [install-dir]/conf/Server.xml file.

JMXOPTIONS=-Dcom.sun.management.jmxremote=true
#JMXOPTIONS="$JMXOPTIONS -Dcom.sun.management.jmxremote.port=1099"
#JMXOPTIONS="$JMXOPTIONS -Dcom.sun.management.jmxremote.authenticate=true"
#JMXOPTIONS="$JMXOPTIONS -Dcom.sun.management.jmxremote.ssl=false"
#JMXOPTIONS="$JMXOPTIONS -Dcom.sun.management.jmxremote.password.file=$WMSCONFIG_HOME/conf/jmxremote.password"
#JMXOPTIONS="$JMXOPTIONS -Dcom.sun.management.jmxremote.access.file=$WMSCONFIG_HOME/conf/jmxremote.access"
#JMXOPTIONS="$JMXOPTIONS -Djava.rmi.server.hostname=192.168.1.7"

if [ "$WMSCOMMAND" != "start" ]; then
        JMXOPTIONS=""
fi

ulimit -n 300000

# log interceptor com.wowza.wms.logging.LogNotify - see Javadocs for ILogNotify

$_EXECJAVA -Duser.timezone="America/Sao_Paulo" $JAVA_OPTS $JMXOPTIONS -Dcom.wowza.wms.AppHome="$WMSAPP_HOME" -Dcom.wowza.wms.ConfigURL="$WMSCONFIG_URL" -Dcom.wowza.wms.ConfigHome="$WMSCONFIG_HOME" -cp $WMSAPP_HOME/bin/wms-bootstrap.jar com.wowza.wms.bootstrap.Bootstrap $WMSCOMMAND >/dev/null 2>&1 &
if [ "$WMSCOMMAND" = "start" ]; then
        echo $! > ${WMSPIDFILE}
        wait $!
fi
exit 0
