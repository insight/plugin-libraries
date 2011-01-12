<?php
/**
 * Requirements:
 *   * unix
 *   * wget
 *   * unzip
 *   * git
 *   * nodejs
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

// ensure plugin declares apf as dependency
$pluginPackageDescriptorPath = $pluginBasePath . DIRECTORY_SEPARATOR . 'package.json';
if(!file_exists($pluginPackageDescriptorPath)) {
    echo 'No package descriptor found at: ' . $pluginPackageDescriptorPath . "\n";
    exit;
}
$pluginPackageDescriptor = json_decode(file_get_contents($pluginPackageDescriptorPath), true);
$found = false;
foreach( $pluginPackageDescriptor['mappings'] as $alias => $info ) {
    if(isset($info['catalog']) && $info['catalog']=='http://registry.pinf.org/jsinsight.org/github/plugin-libraries/packages/catalog.json' &&
       isset($info['name']) && $info['name']=='apf') {
        $found = true;
    }
}
if(!$found) {
    echo 'APF not declared as dependency for plugin package.' . "\n";
    exit;
}


$apfPackagerUrl = 'https://github.com/ajaxorg/packager.git';
$apfPackagerUrlInfo = parse_url($apfPackagerUrl);
$apfPackagerHomePath = $PINF_HOME . DIRECTORY_SEPARATOR . 'workspaces' . DIRECTORY_SEPARATOR . $apfPackagerUrlInfo['host'] . substr($apfPackagerUrlInfo['path'], 0, -4);

if(!file_exists($apfPackagerHomePath)) {
    echo 'Cloning ' . $apfPackagerUrl . ' to ' . $apfPackagerHomePath . "\n";
    if(!file_exists(dirname($apfPackagerHomePath))) {
        mkdir(dirname($apfPackagerHomePath), 0775, true);
    }
    $command = 'git clone ' . $apfPackagerUrl . ' ' . $apfPackagerHomePath;
    echo 'Running: ' . $command . "\n";
    passthru($command);
    if(!file_exists($apfPackagerHomePath)) {
        echo 'ERROR: Repository "' . $apfPackagerUrl . '" could not be cloned!' . "\n";
        exit;
    }

    echo 'Initializing submodules for ' . $apfPackagerHomePath . "\n";
    $command = 'cd ' . $apfPackagerHomePath . ' ; git submodule update --init';
    echo 'Running: ' . $command . "\n";
    passthru($command);
}


function download($url) {
    global $PINF_HOME;

    $urlInfo = parse_url($url);
    $archivePath = $PINF_HOME . DIRECTORY_SEPARATOR . 'downloads' . DIRECTORY_SEPARATOR . $urlInfo['host'] . $urlInfo['path'];
    $homePath = $archivePath . '~contents';
    
    if(!file_exists($homePath)) {
        if(!file_exists($archivePath)) {
            echo 'Downloading ' . $url . ' to ' . $archivePath . "\n";
            if(!file_exists(dirname($archivePath))) {
                mkdir(dirname($archivePath), 0775, true);
            }
            $command = 'wget --no-check-certificate -O ' . $archivePath . ' ' . $url;
            echo 'Running: ' . $command . "\n";
            passthru($command);
            if(!file_exists($archivePath)) {
                echo 'ERROR: File "' . $url . '" could not be downloaded!' . "\n";
                exit;
            }
        }
    
        echo 'Extracting ' . $archivePath . ' to ' . $homePath . "\n";
        $command = 'unzip ' . $archivePath . ' -d ' . $homePath;
        echo 'Running: ' . $command . "\n";
        passthru($command);   
        if(!file_exists($homePath)) {
            echo 'ERROR: File "' . $archivePath . '" could not be extracted!' . "\n";
            exit;
        }
    }
    
    $dirs = scandir($homePath);
    $homePath .= DIRECTORY_SEPARATOR . array_pop($dirs);
    
    return $homePath;
}


// HACK: Check if /pinf/workspaces/github.com/cadorn/apf exists
$apfHomePath = $PINF_HOME . DIRECTORY_SEPARATOR . 'workspaces/github.com/cadorn/apf';
if(!is_dir($apfHomePath)) {
    $apfHomePath = download('https://github.com/ajaxorg/apf/zipball/master');
}


$pilotHomePath = download('https://github.com/ajaxorg/pilot/zipball/master');
$cockpitHomePath = download('https://github.com/ajaxorg/cockpit/zipball/master');
$aceHomePath = download('https://github.com/ajaxorg/ace/zipball/master');
$debugHomePath = download('https://github.com/ajaxorg/lib-v8debug/zipball/master');
$requireHomePath = download('https://github.com/jrburke/requirejs/zipball/master');


$apfSkinHomePath = download('http://cdn.ajax.org/download/beta/apf_skin_aristo_3.02.zip');


// symlink APF into the packager

@unlink($apfPackagerHomePath . DIRECTORY_SEPARATOR . 'support' . DIRECTORY_SEPARATOR . 'apf');
symlink($apfHomePath, $apfPackagerHomePath . DIRECTORY_SEPARATOR . 'support' . DIRECTORY_SEPARATOR . 'apf');

// symlink ACE into the packager

@unlink($apfPackagerHomePath . DIRECTORY_SEPARATOR . 'support' . DIRECTORY_SEPARATOR . 'ace');
symlink($aceHomePath . DIRECTORY_SEPARATOR . 'lib/ace', $apfPackagerHomePath . DIRECTORY_SEPARATOR . 'support' . DIRECTORY_SEPARATOR . 'ace');

// symlink the APR file

@unlink($apfPackagerHomePath . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . 'plugin-build.apr');
symlink($pluginBasePath . DIRECTORY_SEPARATOR . 'scripts/release.apr', $apfPackagerHomePath . DIRECTORY_SEPARATOR . 'projects' . DIRECTORY_SEPARATOR . 'plugin-build.apr');


// build the release

$command = 'cd ' . $apfPackagerHomePath . ' ; node package.js plugin-build.apr';
echo 'Running: ' . $command . "\n";
passthru($command);


// copy output into plugin

$targetPath = $pluginBasePath . DIRECTORY_SEPARATOR . 'resources/apf';

if(is_dir($targetPath)) {
    $command = 'rm -Rf ' . $targetPath;
    echo 'Running: ' . $command . "\n";
    passthru($command);
}
clearstatcache();
if(!is_dir($targetPath)) {
    mkdir($targetPath, 0775, true);
}

copy($apfPackagerHomePath . DIRECTORY_SEPARATOR . 'build/apf_release.js', $targetPath . DIRECTORY_SEPARATOR . 'apf-release.js');


// copy support libs

$command = 'cp -Rf ' . $apfHomePath . ' ' . $targetPath . DIRECTORY_SEPARATOR . 'apf/';
echo 'Running: ' . $command . "\n";
passthru($command);

$command = 'cp -Rf ' . $pilotHomePath . '/lib/pilot ' . $targetPath;
echo 'Running: ' . $command . "\n";
passthru($command);

$command = 'cp -Rf ' . $cockpitHomePath . '/lib/cockpit ' . $targetPath;
echo 'Running: ' . $command . "\n";
passthru($command);

$command = 'cp -Rf ' . $aceHomePath . '/lib/ace ' . $targetPath;
echo 'Running: ' . $command . "\n";
passthru($command);

$command = 'cp -Rf ' . $debugHomePath . '/lib/v8debug ' . $targetPath;
echo 'Running: ' . $command . "\n";
passthru($command);

$command = 'cp -Rf ' . $requireHomePath . '/require ' . $targetPath;
echo 'Running: ' . $command . "\n";
passthru($command);



if(!is_dir($targetPath . DIRECTORY_SEPARATOR . 'skins')) {
    mkdir($targetPath . DIRECTORY_SEPARATOR . 'skins', 0775, true);
}
$command = 'cp -Rf ' . $apfSkinHomePath . '/aristo ' . $targetPath . DIRECTORY_SEPARATOR . 'skins/aristo';
echo 'Running: ' . $command . "\n";
passthru($command);

echo 'DONE' . "\n";
