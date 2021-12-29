<?php

  function loadMonitorsCache($cachePath) {
    $cache = file_get_contents($cachePath);
    $cache = unserialize($cache);
    if (!$cache) {
      $cache = array();
    }
    return $cache;
  }

  function updateMonitorsCache($analysedMonitor) {
    GLOBAL $analysedMonitors;
    for ($i=0; $i < count($analysedMonitors); $i++) {
      if ($analysedMonitors[$i]['hash'] == $analysedMonitor['hash']) {
        $analysedMonitors[$i] = $analysedMonitor;
        return;
      }
    }
    # If the hash wasn't in the array, the monitor was never cached
    # So add it
    array_push($analysedMonitors, $analysedMonitor);

  }

  function saveMonitorsCache($cachePath) {
    GLOBAL $analysedMonitors;
    file_put_contents($cachePath, serialize($analysedMonitors));
  }

  function followRedirectionURL($url) {
    $header = get_headers($url);
    $htmlCode = $header[0];

    // 302 means redirection
    if (strpos ($htmlCode, '302')) {
      $redirectionURL = $header[1];
      $redirectionURL = str_replace("Location: ", "", $redirectionURL);
      return $redirectionURL;
    } elseif (strpos ($htmlCode, '308')) {
      $redirectionURL = $header[2];
      $redirectionURL = str_replace("Location: ", "", $redirectionURL);
      return $redirectionURL;
    }

    return $url;
  }

  function convertURL($sslSite) {
    $sslSite = followRedirectionURL($sslSite);
    $sslSite = parse_url($sslSite)['host'];
    return $sslSite;
  }

  function retrieveSSLData($userdataPath, $rawURL) {
    $sslTestFolder = $userdataPath . 'testSSL/';
    $sslTestExec = $_SERVER['DOCUMENT_ROOT'] .'/testssl.sh';

    $sslSite = convertURL($rawURL);

    $sslDataPath = $sslTestFolder . hash("md4", $sslSite) . '.json';

    // If the file doesn't exist, generate it
    if (!file_exists($sslDataPath)) {

      $command = $sslTestExec . ' --hints --quiet --overwrite --jsonfile ' . $sslDataPath . ' ' . $sslSite;
      $command = escapeshellcmd($command);
      //echo $command . '<br>';
      exec($command);

    }

    $sslData = file_get_contents($sslDataPath);
    $sslData = json_decode($sslData, true);
    return $sslData;
  }

  function retrieveLHData($userdataPath, $rawURL) {
    $lighthouseFolder = $userdataPath . 'lighthouse/';

    $lighthouseSite = $rawURL;
    $lighthouseSite = followRedirectionURL($lighthouseSite);
    $lighthousePath = $lighthouseFolder . hash("md4", $lighthouseSite) . '.json';

    if (!file_exists($lighthousePath)) {

      $command = 'lighthouse ' . $lighthouseSite . ' --chrome-flags="--headless --no-sandbox" --output=json --output-path=' . $lighthousePath;
      $command = escapeshellcmd($command);
      //echo $command;
      exec($command);

    }

    $lhData = file_get_contents($lighthousePath);
    $lhData = json_decode($lhData, true);
    return $lhData;
  }

 ?>
