<applet name="ggbApplet" code="geogebra.GeoGebraApplet" archive="geogebra.jar"
	codebase="http://www.geogebra.org/webstart/3.2/unsigned/"
	width="898" height="511"mayscript="true">
	<param name="image" value="http://www.geogebra.org/webstart/loading.gif"  />
        <?php if($ggbBase64 !== false){
            echo CHtml::tag('param', array(
                'name'=>'ggbBase64',
                'value'=>$ggbBase64,
                'encode'=>FALSE,
            ));
        }?>
        
        <param name="boxborder" value="true"  />
	<param name="centerimage" value="true"  />
	<param name="java_arguments" value="-Xmx512m -Djnlp.packEnabled=true" />
	<param name="cache_archive" value="geogebra.jar, geogebra_main.jar, geogebra_gui.jar, geogebra_cas.jar, geogebra_export.jar, geogebra_properties.jar" />
	<param name="cache_version" value="3.2.47.0, 3.2.47.0, 3.2.47.0, 3.2.47.0, 3.2.47.0, 3.2.47.0" />
	<param name="framePossible" value="false" />
	<param name="showResetIcon" value="false" />
	<param name="showAnimationButton" value="true" />
	<param name="enableRightClick" value="true" />
	<param name="errorDialogsActive" value="true" />
	<param name="enableLabelDrags" value="false" />
	<param name="showMenuBar" value="false" />
	<param name="showToolBar" value="false" />
	<param name="showToolBarHelp" value="false" />
	<param name="showAlgebraInput" value="false" />
	<param name="allowRescaling" value="true" />
This is a Java Applet created using GeoGebra from www.geogebra.org - it looks like you don't have Java installed, please go to www.java.com
</applet>
