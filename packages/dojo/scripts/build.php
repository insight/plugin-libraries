<?php
/**
 * Requirements:
 *   * unix
 *   * wget
 *   * unzip
 * 
 */

$PINF_HOME = getenv('PINF_HOME');
if(!$PINF_HOME || !is_dir($PINF_HOME)) {
    echo 'ERROR: PINF_HOME environment variable not set!' . "\n";
    echo 'It should be set to "/pinf" or equivalent.' . "\n";
    exit;
}

// ensure path to plugin is set and exists
if($_SERVER['argc']==1) {
    echo 'You must pass the path to an insight-plugin package as the first argument!' . "\n";
    exit;
}
$pluginBasePath = realpath($_SERVER['argv'][1]);
if(!$pluginBasePath || !file_exists($pluginBasePath)) {
    echo 'No insight-plugin found at: ' . $_SERVER['argv'][1] . "\n";
    exit;
}

// ensure plugin declares dojo as dependency
$pluginPackageDescriptorPath = $pluginBasePath . DIRECTORY_SEPARATOR . 'package.json';
if(!file_exists($pluginPackageDescriptorPath)) {
    echo 'No package descriptor found at: ' . $pluginPackageDescriptorPath . "\n";
    exit;
}
$pluginPackageDescriptor = json_decode(file_get_contents($pluginPackageDescriptorPath), true);
$found = false;
foreach( $pluginPackageDescriptor['mappings'] as $alias => $info ) {
    if(isset($info['catalog']) && $info['catalog']=='http://registry.pinf.org/jsinsight.org/github/plugin-libraries/packages/catalog.json' &&
       isset($info['name']) && $info['name']=='dojo') {
        $found = true;
    }
}
if(!$found) {
    echo 'Dojo not declared as dependency for plugin package.' . "\n";
    exit;
}

$dojoUrl = 'http://download.dojotoolkit.org/release-1.5.0/dojo-release-1.5.0-src.zip';
$dojoUrlInfo = parse_url($dojoUrl);
$dojoArchivePath = $PINF_HOME . DIRECTORY_SEPARATOR . 'downloads' . DIRECTORY_SEPARATOR . $dojoUrlInfo['host'] . $dojoUrlInfo['path'];
$dojoHomePath = $dojoArchivePath . '~contents';

if(!file_exists($dojoHomePath)) {
    if(!file_exists($dojoArchivePath)) {
        echo 'Downloading ' . $dojoUrl . ' to ' . $dojoArchivePath . "\n";
        if(!file_exists(dirname($dojoArchivePath))) {
            mkdir(dirname($dojoArchivePath), 0775, true);
        }
        $command = 'wget -O ' . $dojoArchivePath . ' ' . $dojoUrl;
        echo 'Running: ' . $command . "\n";
        passthru($command);
        if(!file_exists($dojoArchivePath)) {
            echo 'ERROR: File "' . $dojoUrl . '" could not be downloaded!' . "\n";
            exit;
        }
    }

    echo 'Extracting ' . $dojoArchivePath . ' to ' . $dojoHomePath . "\n";
    $command = 'unzip ' . $dojoArchivePath . ' -d ' . $dojoHomePath;
    echo 'Running: ' . $command . "\n";
    passthru($command);   
    if(!file_exists($dojoHomePath)) {
        echo 'ERROR: File "' . $dojoArchivePath . '" could not be extracted!' . "\n";
        exit;
    }
}

$dojoHomePath .= DIRECTORY_SEPARATOR . 'dojo-release-1.5.0-src';

// look for layers profile file
$layerProfileFile = $pluginBasePath . DIRECTORY_SEPARATOR . 'scripts/dojo.layers.profile.js';
if(!file_exists($layerProfileFile)) {
    echo 'ERROR: No dojo layer profile file found at: ' . $layerProfileFile . "\n";
    exit;
}

$command = 'cd ' . $dojoHomePath . '/util/buildscripts/ ; ./build.sh profileFile=' . $layerProfileFile . ' action=clean,release cssOptimize=comments releaseName=insight-plugin releaseDir=' . $pluginBasePath . '/resources/dojo';
echo 'Running: ' . $command . "\n";
passthru($command);

echo 'DONE' . "\n";
