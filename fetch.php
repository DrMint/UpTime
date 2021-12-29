<?php

  define("NO_ERR", 0);
  define("ERR_DNS", -10);
  define("ERR_NO_REG", -11);
  define("ERR_EMPTY_HTML", -12);
  define("ERR_PING_TIMEOUT", -13);
  define("ERR_UNMATCH_IP", -14);
  define("ERR_INVALID_IP", -15);
  define("ERR_PORT_CLOSED", -16);

  define("SLOW_THRESHOLD", 500);
  define("CACHE_VALIDITY", 280); // In sec

  $analysedMonitors = array();
  $userdataPathGLOBAL = '';

  function generateWebPageMonitors($configPath, $userdataPath) {
    GLOBAL $analysedMonitors, $userdataPathGLOBAL;

    $cachePath  = $userdataPath . '/monitors.cache';

    $analysedMonitors = loadMonitorsCache($cachePath);
    $userdataPathGLOBAL = $userdataPath;

    $config = file_get_contents($configPath);
    $config = json_decode($config, true);


    echo '<div class="pageHeader">';
      if (isset($config['Name'])) echo "<h1>" . $config['Name'] . "</h1>";
      echo 'Welcome ' . $_SESSION['loginUsername'];
      echo '<a href="logout.php">Logout</a>';
      if (isset($config['Description'])) echo "<p class='headerDivider'>|</p><p>" . $config['Description'] . "</p>";
    echo "</div>";

    echo '<div id="monitorsView">';
      parseGroups($config['Groups']);
    echo '</div>';


    saveMonitorsCache($cachePath);

  }

  function generateHashForMonitor($monitor) {
      $data = '';
      if (isset($monitor["Type"])) $data .= $monitor["Type"];
      if (isset($monitor["Hostname"])) $data .= $monitor["Hostname"];
      if (isset($monitor["IPv4"])) $data .= $monitor["IPv4"];
      if (isset($monitor["Port"])) $data .= $monitor["Port"];
      if (isset($monitor["URL"])) $data .= $monitor["URL"];
      if (isset($monitor["HTTP/S"])) $data .= $monitor["HTTP/S"];
      if (isset($monitor["WWW"])) $data .= $monitor["WWW"];
      if (isset($monitor["RegEx"])) $data .= $monitor["RegEx"];
      if (isset($monitor["Keyword"])) $data .= $monitor["Keyword"];
      return hash('md4', $data);
  }

  function getPageTitle($configPath) {
    $config = file_get_contents($configPath);
    $config = json_decode($config, true);
    if (isset($config['Name'])) {
      return $config['Name'];
    } else {
      return '';
    }
  }

  // Tries to connect to the given ip using at given port
  // Returns the time in ms if it worked
  // Else returns -1
  function testPort($ip, $port) {
      $starttime = microtime(true);
      $file      = @fsockopen($ip, $port, $errno, $errstr, 2);
      $stoptime  = microtime(true);
      $status    = 0;

      if (!$file) {
          $status = ERR_PORT_CLOSED;  // Site is down
      } else {
          fclose($file);
          $status = ($stoptime - $starttime) * 1000;
          $status = ceil($status);
      }
      return $status;
  }

  function testKeyword($url, $rule, $isRegEx) {
    $starttime = microtime(true);
    $homepage = file_get_contents($url);
    $stoptime  = microtime(true);
    if (strlen($homepage) == 0) return ERR_EMPTY_HTML;

    if ($isRegEx) {
      $found = preg_match_all($rule, $homepage) > 0;
    } else {
      $found = stristr($homepage, $rule);
    }

    if ($found) {
      $status = ($stoptime - $starttime) * 1000;
      $status = ceil($status);
      return $status;
    } else {
      return ERR_NO_REG;
    }
  }

  function testPing($ip) {
    $result = shell_exec("ping $ip -c 1 -W 0.5");
    $result = explode(PHP_EOL, $result);
    $result = $result[5];
    $result = explode('/', $result);
    $result = $result[4];
    $result = ceil($result);
    if ($result > 0) {
      return $result;
    } else {
      return ERR_PING_TIMEOUT;
    }

  }

  function parseGroups($groups) {
    foreach ($groups as $group) {

      # If the group isn't disabled
      if (!isset($group['Disabled'])) {
        echo '<div class="group">';
        if (isset($group['Name']) or isset($group['Description'])) {
          echo '<div class="groupHeader">';
          if (isset($group['Name'])) echo "<h2>" . $group['Name'] . "</h2>";
          if (isset($group['Description'])) echo "<p class='headerDivider'>|</p><p>" . $group['Description'] . "</p>";
          echo "</div>";
        }
        echo '<div class="monitors">';
        parseMonitors($group['Monitors']);
        echo "</div>";
        echo "</div>";
      }
    }
  }


  function getMonitorFromHash($monitorHash) {
    GLOBAL $analysedMonitors;
    foreach ($analysedMonitors as $analysedMonitor) {
      if ($analysedMonitor['hash'] == $monitorHash) {
        return $analysedMonitor;
      }
    }
    return NULL;
  }

  function isCacheInvalidated($analysedMonitor) {
    if (!is_null($analysedMonitor)) {
      return $analysedMonitor['timestamp'] < getCurrentTime() - CACHE_VALIDITY;
    }
    return false;
  }

  function getCurrentTime() {
    return intval(microtime(true));
  }

  function parseMonitors($monitors) {
    GLOBAL $analysedMonitors, $userdataPathGLOBAL;

    foreach ($monitors as $monitor) {

      # If the monitor isn't disabled
      if (!isset($monitor['Disabled'])) {

        $monitorHash = generateHashForMonitor($monitor);
        $analysedMonitor = getMonitorFromHash($monitorHash);
        if (is_null($analysedMonitor) or isCacheInvalidated($analysedMonitor)) {

          $error = NO_ERR;

          # Verify that the IP is valid
          if (isset($monitor["IPv4"])) {
            if (!filter_var($monitor["IPv4"], FILTER_VALIDATE_IP)) {
              $error = ERR_INVALID_IP;
            }
          }


          if ($error == NO_ERR) {
            if ($monitor['Type'] == 'HTML') {

              # If there isn't a URL, skip this monitor
              if (!isset($monitor["URL"])) {continue;}

              $domain = parse_url($monitor["URL"], PHP_URL_HOST);
              if (!$domain) {
                $domain = parse_url('//' . $monitor["URL"], PHP_URL_HOST);
              }
              $ipv4 = gethostbyname($domain);

              # If there isn't any DNS resolution
              if ($domain == $ipv4) {

                $error = ERR_DNS;

              } else {

                if (isset($monitor["IPv4"])) {

                  # Verify that the IPv4 = URL's (sub)domain DNS resolution
                  if ($monitor["IPv4"] != $ipv4) {

                    $error = ERR_UNMATCH_IP;

                  }

                }
              }

            } else {

              # If there isn't a IPv4 nor a Hostname, skip this monitor
              if (!(isset($monitor["IPv4"]) or isset($monitor["Hostname"]))) {continue;}

              if (isset($monitor["Hostname"])) {
                # Verify that the hostname DNS resolve

                $ipv4 = gethostbyname($monitor["Hostname"]);

                # If there isn't any DNS resolution
                if ($monitor["Hostname"] == $ipv4) {

                  $error = ERR_DNS;

                } else {

                  if (isset($monitor["IPv4"])) {

                    # Verify that the IPv4 = URL's (sub)domain DNS resolution
                    if ($monitor["IPv4"] != $ipv4) {

                      $error = ERR_UNMATCH_IP;

                    }

                  } else {

                    $monitor["IPv4"] = $ipv4;

                  }
                }
              }
            }
          }

          if ($error == NO_ERR) {
            switch ($monitor["Type"]) {

              case 'Ping':
                $time = testPing($monitor["IPv4"]);
                if ($time < NO_ERR) $error = $time;
                break;

              case 'Port':
                $time = testPort($monitor["IPv4"], $monitor["Port"]);
                if ($time < NO_ERR) $error = $time;
                break;

              case 'HTML':

                $urls = array();
                $submonitors = array();

                if (isset($monitor["HTTP/S"])) {

                  if (isset($monitor["WWW"])) {
                    array_push($urls, 'https://www.' . $monitor["URL"]);
                    array_push($urls, 'http://www.' . $monitor["URL"]);
                    array_push($submonitors, 'https-www');
                    array_push($submonitors, 'http-www');
                  }
                  array_push($urls, 'https://' . $monitor["URL"]);
                  array_push($urls, 'http://' . $monitor["URL"]);
                  array_push($submonitors, 'https');
                  array_push($submonitors, 'http');

                } else {

                  if (isset($monitor["WWW"])) {
                    $scheme = parse_url($monitor["URL"], PHP_URL_SCHEME);
                    array_push($urls, $scheme. '://www.' . substr($monitor["URL"], strlen($scheme) + 3));
                    array_push($urls, $scheme. '://' . substr($monitor["URL"], strlen($scheme) + 3));
                    array_push($submonitors, $scheme . '-www');
                    array_push($submonitors, $scheme);
                  } else {
                    array_push($urls, $monitor["URL"]);
                  }

                }

                if (isset($monitor["RegEx"])) {
                  $rule = $monitor["RegEx"];
                  $isRegEx = true;
                } elseif (isset($monitor["Keyword"])) {
                  $rule = $monitor["Keyword"];
                  $isRegEx = false;
                } else {
                  $rule = '/./';
                  $isRegEx = true;
                }

                $times = array();
                foreach ($urls as $url) {
                  $time = testKeyword($url, $rule, $isRegEx);
                  array_push($times, $time);
                  if ($time < NO_ERR) $error = $time;
                }
                $time = ceil(array_sum($times) / count($times));
                break;

            }
          }

          // If it's a new monitor that never got cached and needs to be added
          if (is_null($analysedMonitor)) {
            $analysedMonitor = array();
            $analysedMonitor['hash'] = $monitorHash;
            $analysedMonitor['error'] = $error;
            $analysedMonitor['time'] = $time;
            $analysedMonitor['times'] = $times;
            $analysedMonitor['submonitors'] = $submonitors;
            $analysedMonitor['urls'] = $urls;
            $analysedMonitor['timestamp'] = getCurrentTime();
            updateMonitorsCache($analysedMonitor);

          // If the cache is old and needs to be updated
          } else {
            $analysedMonitor['error'] = $error;
            $analysedMonitor['time'] = $time;
            $analysedMonitor['times'] = $times;
            $analysedMonitor['timestamp'] = getCurrentTime();
            updateMonitorsCache($analysedMonitor);
          }

        // If the cache is still valid and can be used
        } else {

          $error = $analysedMonitor['error'];
          $time = $analysedMonitor['time'];
          $times = $analysedMonitor['times'];
          $submonitors = $analysedMonitor['submonitors'];
          $urls = $analysedMonitor['urls'];

        }


        # DISPLAY THE RESULTS

        # Prepare the title and link
        switch ($monitor["Type"]) {

          case 'Ping':
            if (isset($monitor["Hostname"])) {
              if (isset($monitor["IPv4"])) {
                $link = $monitor["Hostname"] . ' (' . $monitor["IPv4"] . ')';
              } else {
                $link = $monitor["Hostname"];
              }
            } else {
              $link = $monitor["IPv4"];
            }
            $linkURL = '#';
            break;

          case 'Port':
            $link = $monitor["IPv4"] . ':' . $monitor["Port"];

            if (isset($monitor["Hostname"])) {
              if (isset($monitor["IPv4"])) {
                $link = $monitor["Hostname"] . ':' . $monitor["Port"] . ' (' . $monitor["IPv4"] . ')';
              } else {
                $link = $monitor["Hostname"] . ':' . $monitor["Port"];
              }
            } else {
              $link = $monitor["IPv4"] . ':' . $monitor["Port"];
            }

            $linkURL = '//' . $link;
            break;

          case 'HTML':
            $link = $monitor["URL"];

            if (isset($urls[0])) {
              $linkURL = $urls[0];
            } else {
              $linkURL = $link;
            }

            break;

        }



        # If there's no error
        if ($error == NO_ERR) {
          if ($time < SLOW_THRESHOLD) {
            $severity = 'OK';
          } else {
            $severity = 'LOW';
          }
        } else {
          $severity = 'HIGH';
        }

        //$description = '<a class=\\\'link\\\' href=\\\'https://up.barillot.net/?web=' . $linkURL . '\\\' target=\\\'_blank\\\'*/>WebDev Score</a>';
        //$description = '<a class=\\\'link\\\' href=\\\'https://up.barillot.net/?web=' . $linkURL . '\\\'/>WebDev Score</a><br>';
        //$description .= '<a class=\\\'link\\\' href=\\\'https://up.barillot.net/?ssl=' . $linkURL . '\\\'/>SSL Score</a><br>';

        if ($monitor["Type"] == 'HTML') {

          //SSL Score
          $sslData = retrieveSSLData($userdataPathGLOBAL, $linkURL);
          foreach ($sslData as $value) {
            if ($value[id] == 'overall_grade') {
              $sslGrade = $value;
              break;
            }
          }
          $description  = '<a class=\\\'subPageLink ' . $sslGrade[severity] . '\\\' href=\\\'https://up.barillot.net/?ssl=' . $linkURL . '\\\'/>SSL Score: ' . $sslGrade[finding] . '</a><br>';

          $lhData = retrieveLHData($userdataPathGLOBAL, $linkURL);
          $lhScore = 0.0;
          $lhScore += $lhData[categories][performance][score]      * 0.3;
          $lhScore += $lhData[categories][accessibility][score]    * 0.2;
          $lhScore += $lhData[categories]['best-practices'][score] * 0.2;
          $lhScore += $lhData[categories][seo][score]              * 0.2;
          $lhScore += $lhData[categories][pwa][score]              * 0.1;
          $lhScore = round($lhScore * 100);

          if ($lhScore < 50) {
            $lhSeverity = 'HIGH';
          } elseif ($lhScore < 90) {
            $lhSeverity = 'LOW';
          } else {
            $lhSeverity = 'OK';
          }

          $description .= '<a class=\\\'subPageLink ' . $lhSeverity .'\\\' href=\\\'https://up.barillot.net/?web=' . $linkURL . '\\\'/>WebDev Score: ' . $lhScore .'</a>';
        }

        echo '<div class="monitor ' . $severity . '" onclick="openSidePanel(\'' . $link . '\', \'' . $severity . '\', \'' . $description . '\', \'' . "" . '\')">';


        /*
        if ($linkURL != '#') {
          echo "<a class='link' href='$linkURL' target='_blank'>$link</a>";
        } else {
          echo "<a class='link' href='$linkURL'>$link</a>";
        }
        */
        echo "<p>$link</p>";

        # Add the custom description from the JSON
        if (isset($monitor["Description"])) {
          echo "<p class='description'>" . $monitor["Description"] . "</p>";
        }

        # Add the second line of information for monitors of type Port and HTML
        if ($monitor["Type"] == 'Port') {
          $portName = getservbyport($monitor["Port"], 'tcp');
          if (!$portName) {
            if (isset($monitor["Service"])) {
              $portName = $monitor["Service"] . ') (Uncommon';
            } else {
              $portName = 'Unknown';
            }
          }

          echo "<p class='secondLine'>Port: " . $monitor["Port"] . " (" . $portName . ")</p>";

        } elseif ($monitor["Type"] == 'HTML') {

          if (isset($monitor["RegEx"]) or isset($monitor["Keyword"])) {
            echo "<p class='secondLine'>Rule: " . $monitor["RegEx"] . $monitor["Keyword"] ."</p>";
          }

        }

        # Add multiple sub-monitors if HTTP/S and/or WWW is enable
        if (count($submonitors) > 0) {
          echo '<div class="submonitors">';
          $index = 0;
          foreach ($submonitors as $submonitor) {
            if ($times[$index] < NO_ERR) {
              echo "<p class='submonitor HIGH'>$submonitor</p>";
            } else {
              if ($times[$index] < SLOW_THRESHOLD) {
                echo "<p class='submonitor OK'>$submonitor</p>";
              } else {
                echo "<p class='submonitor LOW'>$submonitor</p>";
              }
            }
            $index += 1;
          }
          echo '</div>';
        }


        # Add the monitor type's icon
        echo "<img src='img/" . $monitor["Type"] . ".webp' alt=''>";


        # Add bottom main value or error
        if ($error == NO_ERR) {
          $msMessage = "$time ms";
        } else {
          switch ($error) {
            case ERR_EMPTY_HTML:    $msMessage = "Empty page"; break;
            case ERR_NO_REG:        $msMessage = "RegEx not found"; break;
            case ERR_PING_TIMEOUT:  $msMessage = "Timeout"; break;
            case ERR_DNS:           $msMessage = "No DNS resolve"; break;
            case ERR_UNMATCH_IP:    $msMessage = "IP doesn't match"; break;
            case ERR_INVALID_IP:    $msMessage = "IP is invalid"; break;
            case ERR_PORT_CLOSED:   $msMessage = "Port is closed"; break;
            default:                $msMessage = "WTF? ($error)"; break;
          }
        }

        echo "<p class='result'>$msMessage</p>";
        echo '</div>';

      }

    }
  }

 ?>
