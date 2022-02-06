<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<div id='modal_alert'></div>

<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="weatherTab">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th style="text-align: center;" class="col-sm-2">{{Condition}}</th>
                    <th style="text-align: center;" class="col-sm-4">{{Jour}}</th>
                    <th style="text-align: center;" class="col-sm-4">{{Nuit}}</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach (designImgSwitch::$_weatherConditions as $key => $desc) {
                    echo ('<tr>');
                    echo ('<td style="text-align: center; vertical-align:middle; font-weight: bold;">' . __($desc, __FILE__) . '</td>');
                    echo ('<td align="center">');
                    echo ('<div class="col-xs-9">');
                    echo ('<img src="plugins/designImgSwitch/core/' . designImgSwitch::getPicturePath('day', $key) . '?' . mt_rand() . '" weather-condition="' . $key . '" period-condition="day" class="img-responsive" style="max-height : 120px;" >');
                    echo ('</div>');
                    echo ('<div class="col-xs-3">');
                    echo ('<span class="btn btn-default btn-file" style="margin-bottom:10px;">');
                    echo ('<i class="fas fa-cloud-upload-alt"></i> {{Envoyer}}<input class="pluginAction" data-action="uploadImage" weather-condition="' . $key . '" period-condition="day" type="file" name="file" style="display: inline-block;">');
                    echo ('</span>');
                    echo ('<a class="btn btn-danger pluginAction" data-action="deleteImage" weather-condition="' . $key . '" period-condition="day"><i class="fas fa-undo"></i> {{Défaut}}</a>');
                    echo ('</div>');
                    echo ('</td>');
                    echo ('<td align="center">');
                    echo ('<div class="col-xs-9">');
                    echo ('<img src="plugins/designImgSwitch/core/' . designImgSwitch::getPicturePath('night', $key) . '?' . mt_rand() . '" weather-condition="' . $key . '" period-condition="night" class="img-responsive" style="max-height : 120px;" >');
                    echo ('</div>');
                    echo ('<div class="col-xs-3">');
                    echo ('<span class="btn btn-default btn-file" style="margin-bottom:10px;">');
                    echo ('<i class="fas fa-cloud-upload-alt"></i> {{Envoyer}}<input class="pluginAction" data-action="uploadImage" weather-condition="' . $key . '" period-condition="night" type="file" name="file" style="display: inline-block;">');
                    echo ('</span>');
                    echo ('<a class="btn btn-danger pluginAction" data-action="deleteImage" weather-condition="' . $key . '" period-condition="night"><i class="fas fa-undo"></i> {{Défaut}}</a>');
                    echo ('</div>');
                    echo ('</td>');
                    echo ('</tr>');
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include_file('desktop', 'config', 'js', 'designImgSwitch');
?>