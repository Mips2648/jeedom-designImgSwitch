<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }

    ajax::init(array('uploadCustomImg'));

    if (init('action') == 'uploadCustomImg') {
        $weather = init('weather');
        $period = init('period');
        log::add('designImgSwitch', 'debug', "uploadCustomImg weather: {$weather} | period: {$period}");

		if (!isset($_FILES['file'])) {
			throw new Exception(__('Aucun fichier trouvé. Vérifiez le paramètre PHP (post size limit)', __FILE__));
		}
		$extension = strtolower(strrchr($_FILES['file']['name'], '.'));
		if (!in_array($extension, array('.jpg', '.png'))) {
			throw new Exception('Extension du fichier non valide (autorisé .jpg .png) : ' . $extension);
		}
		if (filesize($_FILES['file']['tmp_name']) > 5000000) {
			throw new Exception(__('Le fichier est trop gros (maximum 5Mo)', __FILE__));
        }

        $filepath = __DIR__ . "/../pictures/custom/{$period}-{$weather}{$extension}";
        log::add('designImgSwitch', 'debug', "filepath: {$filepath}");
		file_put_contents($filepath,file_get_contents($_FILES['file']['tmp_name']));
		if(!file_exists($filepath)){
			throw new \Exception(__('Impossible de sauvegarder l\'image',__FILE__));
		}

        $return = array(
            'weather' => $weather,
            'period' => $period,
            'url' => 'plugins/designImgSwitch/core/'.designImgSwitch::getPicturePath($period, $weather)
            );
        ajax::success($return);
    }

    if (init('action') == 'deleteCustomImg') {
        $weather = init('weather');
        $period = init('period');
        log::add('designImgSwitch', 'debug', "deleteImage weather: {$weather} | period: {$period}");

		$files = ls(__DIR__ . '/../pictures/custom/', "{$period}-{$weather}*");
		if(count($files)  > 0){
			foreach ($files as $file) {
                log::add('designImgSwitch', 'debug', "delete file : {$file}");
				unlink(__DIR__ . '/../pictures/custom/'.$file);
			}
        }
        $return = array(
            'weather' => $weather,
            'period' => $period,
            'url' => 'plugins/designImgSwitch/core/'.designImgSwitch::getPicturePath($period, $weather)
            );
        ajax::success($return);
    }

    throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayException($e), $e->getCode());
}