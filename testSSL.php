<?php

define("SSL_DISPLAY_ID", 0);
define("SSL_DISPLAY_VALUE", 1);
define("SSL_DISPLAY_BOTH", 2);
define("SSL_DISPLAY_NONE", 3);
define("SSL_DISPLAY_TABLE", 5);
define("SSL_DISPLAY_SIMUL", 6);

$GLOBALS['labelsAnalysed'] = array();

function labelToDisplayedName($label) {
  switch ($label) {

    // bilan

    case 'overall_grade':  return 'Overall Grade';
    case 'grade_cap_reason_1': return 'Grade Cap Reason';
    case 'final_score': return 'Scores';

    // Protocols

    case 'TLS1':        return 'TLS 1';
    case 'TLS1_1':      return 'TLS 1.1';
    case 'TLS1_2':      return 'TLS 1.2';
    case 'TLS1_3':      return 'TLS 1.3';
    case 'NPN':         return 'NPN/SPDY';
    case 'ALPN_HTTP2':  return 'ALPN/HTTP2';

    // Cypher's categories
    case 'cipherlist_NULL':       return 'NULL ciphers (no encryption)';
    case 'cipherlist_aNULL':      return 'Anonymous NULL Ciphers (no authentication)';
    case 'cipherlist_EXPORT':     return 'Export ciphers (w/o ADH+NULL)';
    case 'cipherlist_LOW':        return 'LOW: 64 Bit + DES, RC[2,4], MD5 (w/o export)';
    case 'cipherlist_3DES_IDEA':  return 'Triple DES Ciphers / IDEA';
    case 'cipherlist_AVERAGE':    return 'Obsoleted CBC ciphers (AES, ARIA etc.)';
    case 'cipherlist_GOOD':       return ' Strong encryption (AEAD ciphers) with no FS';
    case 'cipherlist_STRONG':     return 'Forward Secrecy strong encryption (AEAD ciphers)';

    // Server cypher
    case 'cipher_order':              return 'Cipher order';
    case 'protocol_negotiated':       return 'Negotiated protocol';
    case 'cipher_negotiated':         return 'Negotiated cipher';
    case 'supportedciphers_TLSv1':    return 'Supported TLS 1 Cyphers';
    case 'supportedciphers_TLSv1_1':  return 'Supported TLSv 1.1 Cyphers';
    case 'supportedciphers_TLSv1_2':  return 'Supported TLSv 1.2 Cyphers';
    case 'supportedciphers_TLSv1_3':  return 'Supported TLSv 1.3 Cyphers';


    // Robust forward
    case 'FS':                    return 'FS';
    case 'FS_ciphers':            return 'FS Ciphers';
    case 'FS_ECDHE_curves':       return 'Elliptic curves offered';
    case 'DH_groups':             return 'DH group offered';

    // Server Default

    case 'TLS_extensions':              return 'TLS extensions (standard)';
    case 'TLS_session_ticket':          return 'Session Ticket RFC 5077 hint';
    case 'SSL_sessionID_support':       return 'SSL Session ID support';
    case 'sessionresumption_ticket':    return 'Session Resumption Ticket';
    case 'sessionresumption_ID':        return 'Session Resumption Id';
    case 'TLS_timestamp':               return 'TLS clock skew';
    //case 'cert_numbers':                return 'aaaaaaaaaaaaaaaaaaaaaaa';
    case 'cert_signatureAlgorithm':     return 'Signature Algorithm';
    case 'cert_keySize':                return 'Server key size';
    case 'cert_keyUsage':               return 'Server key usage';
    case 'cert_extKeyUsage':            return 'Server extended key usage';
    case 'cert_serialNumber':           return 'Serial';
    case 'cert_fingerprintSHA1':        return 'Fingerprint SHA1';
    case 'cert_fingerprintSHA256':      return 'Fingerprint SHA256';
    //case 'cert':                        return 'aaaaaaaaaaaaaaaaaaaaaaa';

    // cert

    case 'cert_commonName':             return 'Common Name (CN)';
    //case 'cert_commonName_wo_SNI':      return '';
    case 'cert_subjectAltName':         return 'Subject Alt Name (SAN)';
    case 'cert_trust':                  return 'Trust (hostname)';
    case 'cert_chain_of_trust':         return 'Chain of trust';
    case 'cert_certificatePolicies_EV': return 'EV cert (experimental)';
    case 'cert_expirationStatus':       return 'Certificate Validity (UTC)';
    case 'cert_notBefore':              return 'Certificate Issue Date';
    case 'cert_notAfter':               return 'Certificate Expiry Date';
    case 'cert_extlifeSpan':            return 'Certificate Extended Life Span';
    case 'cert_eTLS':                   return 'ETS/"eTLS", visibility info';
    case 'cert_crlDistributionPoints':  return 'Certificate Revocation List';
    case 'cert_ocspURL':                return 'OCSP URI';
    case 'OCSP_stapling':               return 'OCSP Stapling';
    case 'cert_ocspRevoked':            return 'OCSP Status';
    case 'cert_mustStapleExtension':    return 'OCSP must staple extension';
    case 'DNS_CAArecord':               return 'DNS CAA RR (experimental)';
    case 'certificate_transparency':    return 'Certificate Transparency';
    case 'certs_countServer':           return 'Certificates provided';
    case 'certs_list_ordering_problem': return 'Certificates ordering problem';
    case 'cert_caIssuers':              return 'Issuer';
    case 'intermediate_cert_badOCSP':   return 'Intermediate Bad OCSP (exp.)';

    // HTTP header

    case 'HTTP_status_code':    return 'HTTP Status Code';
    case 'HTTP_clock_skew':     return 'HTTP clock skew';
    case 'HSTS_time':           return 'Strict Transport Security (HSTS)';
    case 'HSTS_subdomains':     return 'HSTS ';
    case 'HSTS_preload':        return 'HSTS Preload';
    case 'HPKP':                return 'HPKP';
    case 'banner_server':       return 'Server banner';
    case 'banner_application':  return 'Application banner';
    case 'cookie_count':        return 'Cookie(s)';
    case 'cookie_secure':       return 'Cookie(s) secure';
    //case 'cookie_httponly':     return 'Cookie(s)';
    case 'banner_reverseproxy': return 'Reverse Proxy banner';

    // Vulnerabilities

    case 'heartbleed':            return 'Heartbleed';
    case 'ticketbleed':           return 'Ticketbleed';
    case 'secure_renego':         return 'Secure Renegotiation';
    case 'secure_client_renego':  return 'Secure Client-Initiated Renegotiation';
    case 'CRIME_TLS':             return 'CRIME, TLS';
    case 'POODLE_SSL':            return 'POODLE, SSL';
    case 'fallback_SCSV':         return 'TLS FALLBACK SCSV';
    case 'heartbleed':            return 'Heartbleed';
    case 'BEAST_CBC_TLS1':        return 'BEAST (TLS1)';
    case 'LOGJAM-common_primes':  return 'LOGJAM Common Prime';
    case 'winshock':              return 'Winshock';
    case 'DROWN_hint':            return 'DROWN Detail';

    // Client simulations

    case 'clientsimulation-android_442':          return 'Android 4.4.2';
    case 'clientsimulation-android_500':          return 'Android 5.0.0';
    case 'clientsimulation-android_60':           return 'Android 6.0';
    case 'clientsimulation-android_70':           return 'Android 7.0';
    case 'clientsimulation-android_81':           return 'Android 8.1';
    case 'clientsimulation-android_90':           return 'Android 9.0';
    case 'clientsimulation-android_X':            return 'Android 10.0';
    case 'clientsimulation-chrome_74_win10':      return 'Chrome 74 (Win 10)';
    case 'clientsimulation-chrome_79_win10':      return 'Chrome 79 (Win 10)';
    case 'clientsimulation-firefox_66_win81':     return 'Firefox 66 (Win 8.1/10)';
    case 'clientsimulation-firefox_71_win10':     return 'Firefox 71 (Win 10)';
    case 'clientsimulation-ie_6_xp':              return 'IE 6 (XP)';
    case 'clientsimulation-ie_8_win7':            return 'IE 8 (Win 7)';
    case 'clientsimulation-ie_8_xp':              return 'IE 8 (XP)';
    case 'clientsimulation-ie_11_win7':           return 'IE 11 (Win 7)';
    case 'clientsimulation-ie_11_win81':          return 'IE 11 (Win 8.1)';
    case 'clientsimulation-ie_11_winphone81':     return 'IE 11 (Win Phone 8.1)';
    case 'clientsimulation-ie_11_win10':          return 'IE 11 (Win 10)';
    case 'clientsimulation-edge_15_win10':        return 'Edge 15 (Win 10)';
    case 'clientsimulation-edge_17_win10':        return 'Edge 17 (Win 10)';
    case 'clientsimulation-opera_66_win10':       return 'Opera 66 (Win 10)';
    case 'clientsimulation-safari_9_ios9':        return 'Safari 9 (iOS 9)';
    case 'clientsimulation-safari_9_osx1011':     return 'Safari 9 (OS X 10.11)';
    case 'clientsimulation-safari_10_osx1012':    return 'Safari 10 (OS X 10.12)';
    case 'clientsimulation-safari_121_ios_122':   return 'Safari 12.1 (iOS 12.2)';
    case 'clientsimulation-safari_130_osx_10146': return 'Safari 13.0 (macOS 10.14.6)';
    case 'clientsimulation-apple_ats_9_ios9':     return 'Apple ATS 9 iOS 9';
    case 'clientsimulation-java_6u45':            return 'Java 6u45';
    case 'clientsimulation-java_7u25':            return 'Java 7u25';
    case 'clientsimulation-java_8u161':           return 'Java 8u161';
    case 'clientsimulation-java1102':             return 'Java 11.0.2 (OpenJDK)';
    case 'clientsimulation-java1201':             return 'Java 12.0.1 (OpenJDK)';
    case 'clientsimulation-openssl_102e':         return 'OpenSSL 1.0.2e';
    case 'clientsimulation-openssl_110l':         return 'OpenSSL 1.1.0l (Debian)';
    case 'clientsimulation-openssl_111d':         return 'OpenSSL 1.1.1d (Debian)';
    case 'clientsimulation-thunderbird_68_3_1':   return 'Thunderbird (68.3)';

  }
  return $label;
}

function getLabelDescription($label) {

  switch ($label) {

    //Bilan

    case 'overall_grade': return 'The scores are calculated using Labs\\\'s \\\'SSL Server Rating Guide\\\' (version 2009q from 2020-01-30).<br><br><ol><li>Verify that the certificate is valid and trusted.</li><li>We inspect server configuration in three categories: Protocol, Key exchange, and Cipher support</li><li>The combine the category scores into an overall score (expressed as a number between 0 and 100). A zero in any category will push the overall score to zero. Then, a letter grade is calculated, using the table below.</li></ol><table><tr><th>Numerical Score</th><th>Grade</th></tr><tr><td>score >= 80</td><td>A</td></tr><tr><td>score >= 65</td><td>B</td></tr><tr><td>score >= 50</td><td>C</td></tr><tr><td>score >= 35</td><td>D</td></tr><tr><td>score >= 20</td><td>E</td></tr><tr><td>score < 20</td><td>F</td></tr></table><br>In certain situations we avoid the standard A-F grades if we think we have encountered a situation that is out of scope. That is the case with the M grade (certificate name mismatch) and the T grade (site certificate is not trusted). When there is no certificate trust, the actual security grade doesn\\\'t matter because active network attackers can subvert connection security.<br><br><a href=\\\'https://github.com/ssllabs/research/wiki/SSL-Server-Rating-Guide\\\' target=\\\'_blank\\\'>Learn more about the specification.</a>';
    case 'grade_cap_reason_1': return 'Some criterias are required to get a certain grade, such as not offering TLS 1.0 or TLS 1.1. Some vulnerabilities can cripple the grade such as POODLE.';
    case 'final_score': return 'SSL is a complex hybrid protocol with support for many features across several phases of operation. To account for the complexity, we rate the configuration of an SSL server in three categories, as displayed in . We calculate the final score as a combination of the scores in the individual categories, weighted as follow:<br><br><table><tr><th>Category</th><th>Weight</th></tr><tr><td>Protocol support</td><td>30%</td></tr><tr><td>Key exchange</td><td>30%</td></tr><tr><td>Cipher strength</td><td>40%</td></tr></table>';

    // Protocols

    case 'SSLv2': return 'SSLv2 has been created by Netscape in 1995 and SSLv3 by the same company in 1996. From the start, SSLv2 showed weaknesses and has quickly been replaced by SSLv3. TLS is now, and since several years, the standard.<br><br>Those protocols, too often used, are vulnerable to Man In The Middle (MITM) attacks allowing a third part to intercept, modify and decypher transferred data.';
    case 'SSLv3': return 'Up until 2014 many public servers continued to support SSLv3 for backward compatibility, despite its supersession by TLS fifteen years beforehand. This trade-off is now unacceptable in light of the irreparable POODLE vulnerability. Disabling SSL 3.0 ensures that software cannot misconfigured to use it, and that attackers cannot force a client and server to downgrade to it.';
    case 'TLS1': return 'TLS 1.0 and TLS 1.1 protocols have been replaced by TLS 1.2 in 2008 that should be used since then.<br><br>Those 2 protocols must now disappear for security reasons and several browsers have already announced their deprecation as of March 2020.<br><br>Their weeknesses (among others) :<ul><li>they require implementation of older cipher suites</li><li>lack of support for current recommended cipher suites</li><li>integrity of the handshake depends on SHA-1 hash</li><li>authentication of the peers depends on SHA-1 signatures</li></ul>It makes them vulnerable to Man In The Middle (MITM) attacks allowing a third part to intercept, modify and decypher transferred data.';
    case 'TLS1_1': return getLabelDescription('TLS1');
    case 'TLS1_2': return 'Version 1.2 of the Transport Layer Security (TLS) protocol published in 2008. Allows for data/message confidentiality, and message authentication codes for message integrity and as a by-product message authentication.';
    case 'TLS1_3': return 'Version 1.3, published in 2018, is the latest version of the Transport Layer Security (TLS) protocol. Removes weaker elliptic curves and hash functions. TLS 1.3 is supported on more than 90% of devices and most browsers.';
    case 'NPN': return 'SPDY is a deprecated open-specification networking protocol that was developed primarily at Google for transporting web content. It should not be used as it has been reported to be vulnerable to CRIME attack.';
    case 'ALPN': return 'Application-Layer Protocol Negotiation (ALPN) is a Transport Layer Security (TLS) extension that allows the application layer to negotiate which protocol should be performed over a secure connection in a manner that avoids additional round trips and which is independent of the application-layer protocols.';

    // Cipher categories

    case 'cipherlist_NULL': return 'Null cipher suites do not provide any data encryption and/or data integrity. They should never be used.';
    case 'cipherlist_aNULL': return 'No browsers offers anonymous cipher suites (at least by default) so it should be not be offered. This cipher suite provides for confidentiality without the need for a certificate authority - an endpoint must be configured to remember what certificates it will accept, instead of which certificate authorities it will accept. This is a completely different trust model from that generally used on the internet, and should not be used on a public website.';
    case 'cipherlist_EXPORT': return 'The cipher suite EXPORT is, by design, weak. They are encrypted, but only with keys small enough to be cracked with even amateur hardware.<br><br>These suites were defined to comply with the US export rules on cryptographic systems, rules which were quite strict before 2000. Nowadays, these restrictions have been lifted and there is little point in supporting the EXPORT cipher suites.';
    case 'cipherlist_LOW': return 'Those ciphers are qualified as LOW because they are using short block size (< 128-bit), or have well-documented vulnerabilities. They should not be offered.<br><br>DES is an old block cipher which uses a 56-bit key. A 56-bit key is crackable. Deep crack was a special-purpose machine built in 1998 for about 250,000 $, and could crack a 56-bit DES key within 4.5 days on average. Technology has progressed, and this can be reproduced with affordable hardware by many individuals. This is true for all 64-bit block ciphers.<br><br>As of 2010, the CMU Software Engineering Institute considers MD5 cryptographically broken and unsuitable for further use, and most U.S. government applications now require the SHA-2 family of hash functions.';
    case 'cipherlist_3DES_IDEA': return '3DES is a ciphersuite based on the Data Encryption Standard developed by IBM in the early 1970s and adopted by NIST in 1977. In 1997, NIST announced a formal search for candidate algorithms to replace DES. In 2001, AES was released with the intention of coexisting with 3DES until 2030, permitting a gradual transition. However, the retirement of 3DES has been likely accelerated by research which has revealed significant vulnerabilities and is, by some accounts, long overdue.<br><br>NIST first initiated discussion of deprecating 3DES following the analysis and demonstration of attacks on 3DES. The Sweet32 vulnerability was made public by researchers Karthikeyan Bhargavan and Gaëtan Leurent. This research exploited a known vulnerability to collision attacks in 3DES and other 64-bit block cipher suites which are greatest during lengthy transmissions, the exchange of content files, or transmissions vulnerable to text injection. After the exposure of this vulnerability, NIST proposed 3DES be deprecated, and soon thereafter, restricted its usage.<br><br>This cipher suite should preferably be avoided';


    // Robust fs
    case 'FS': return 'The FS acronym stands for Forward Secrecy which is a relatively recent security feature for websites. It aims to prevent future exploits and security breaches from compromising current or past communication, information or data by isolating each transaction’s encryption.<br><br>Traditionally, encrypted data would be protected by a single private encryption key held by the server, which it could use to decrypt all the historic communication with the server using a public key. Forward secrecy solves this problem by removing the reliance on a single server private key. Rather than using the same encryption key for every single transaction, a new, unique session key is generated every time a new data transaction occurs.';
  }
  return "Description $label";
}

function getLabelProblem($label, $severity, $message) {
  switch ($label) {

    // Protocols

    case 'SSLv2':
      if ($severity != 'OK') {
        return 'SSLv2 should never EVER be used! It has been deprecated in 2011.<br><br><a href=\\\'https://up.barillot.net/guides/protocols/configure-supported-protocols\\\' target=\\\'_blank\\\'>Read our guide on how to correctly configure your server\\\' supported protocols</a>';
      }
      break;

    case 'SSLv3':
      if ($severity != 'OK') {
        return '<a href=\\\'https://up.barillot.net/guides/protocols/configure-supported-protocols\\\' target=\\\'_blank\\\'>Read our guide on how to correctly configure your server\\\' supported protocols</a>';
      }
      break;

    case 'TLS1':
      if ($severity != 'OK' AND $severity != 'INFO') {
        return 'TLS 1.0 is vulnerable in many implementations to a couple well-known attacks such as BEAST and POODLE. As such TLS 1.0 should always be disabled.<br><br><a href=\\\'https://up.barillot.net/guides/protocols/configure-supported-protocols\\\' target=\\\'_blank\\\'>Read our guide on how to correctly configure your server\\\' supported protocols</a>';
      }
      break;

      case 'TLS1_1':
        if ($severity != 'OK' AND $severity != 'INFO') {
          return 'Newer TLS versions are better designed and better address the potential for new vulnerabilities. As such TLS 1.1 should be disabled. There may still be some special circumstances of old, embedded devices/browsers for which you might need to keep TLS 1.1 enabled (such as Internet Explorer 11).<br><br><a href=\\\'https://up.barillot.net/guides/protocols/configure-supported-protocols\\\' target=\\\'_blank\\\'>Read our guide on how to correctly configure your server\\\' supported protocols</a>';
        }
        break;

    case 'TLS1_3':
      if ($severity != 'OK') {
        return '<a href=\\\'https://up.barillot.net/guides/protocols/configure-supported-protocols\\\' target=\\\'_blank\\\'>Read our guide on how to correctly configure your server\\\' supported protocols</a>';
      }
      break;

    case 'ALPN':
      if ($severity != 'OK') {
        return 'Your server does not support HTTP/2, a major revision of the HTTP network protocol. It was derived from the earlier experimental SPDY protocol.<br><br>Most major browsers had added HTTP/2 support by the end of 2015. About 98% of web browsers used have the capability, while according to W3Techs, as of August 2020, 49% of the top 10 million websites supported HTTP/2.<br><br><a href=\\\'https://up.barillot.net/guides/protocols/enable-http2\\\' target=\\\'_blank\\\'>Read our guide on how to enable HTTP/2 on your server</a>';
      }
      break;

    case 'cipherlist_NULL':
      if ($severity != 'OK' AND $severity != 'INFO') {
        return '<a href=\\\'https://up.barillot.net/guides/cipherlist/configure-offered-ciphers\\\' target=\\\'_blank\\\'>Read our guide on how to offer the right ciphers</a>';
      }
      break;

    case 'cipherlist_aNULL': return getLabelProblem('cipherlist_NULL', $severity, $message);
    case 'cipherlist_EXPORT': return getLabelProblem('cipherlist_NULL', $severity, $message);
    case 'cipherlist_LOW': return getLabelProblem('cipherlist_NULL', $severity, $message);
    case 'cipherlist_3DES_IDEA': return getLabelProblem('cipherlist_NULL', $severity, $message);
    case 'cipherlist_AVERAGE': return getLabelProblem('cipherlist_NULL', $severity, $message);
    case 'cipherlist_GOOD': return getLabelProblem('cipherlist_NULL', $severity, $message);
    case 'cipherlist_STRONG': return getLabelProblem('cipherlist_NULL', $severity, $message);

  }
}


function sslDataFind($sslData, $label) {
  array_push($GLOBALS['labelsAnalysed'], $label);

  foreach ($sslData as $value) {
    if (isset($value[id]) AND $value[id] == $label) {
      return $value;
    }
  }
}

function sslCreateDiv($result, $mode = SSL_DISPLAY_ID) {
  $label = $result[id];
  if ($mode == SSL_DISPLAY_SIMUL) {
    if ($result[finding] == 'No connection') {
      echo '<div class="LOW">';
    } else {
      echo '<div class="OK">';
    }
  } else {
    echo '<div class="' . $result[severity] . '" onclick="openSidePanel(\'' . labelToDisplayedName($label) . '\', \'' . $result[severity] . '\', \'' . getLabelDescription($label) . '\', \'' . getLabelProblem($label, $result[severity], $result[finding]) . '\')">';
  }

  switch ($mode) {
    case SSL_DISPLAY_ID:
      echo '<p>' . labelToDisplayedName($label) . '</p>';
      break;

    case SSL_DISPLAY_VALUE:
      echo '<p>' . $result[finding] . '</p>';
      break;

    case SSL_DISPLAY_BOTH:
      echo '<p class="title">' . labelToDisplayedName($label) . '</p>';
      echo '<p>' . $result[finding] . '</p>';
      break;

    case SSL_DISPLAY_NONE:
      echo '<p class="title"></p>';
      break;

    case SSL_DISPLAY_TABLE:
      var_dump($result[finding]);
      break;

    case SSL_DISPLAY_SIMUL:
      echo '<p>' . labelToDisplayedName($label) . '</p>';
      if ($result[finding] == 'No connection') {
        echo '<p>' . $result[finding] . '</p>';
      }
      break;

    default:
      echo '<p>aaaaaaaaaaaaaaaaa</p>';
      break;
  }

  echo '</div>';
}

function sslPrint($sslData, $label, $mode = SSL_DISPLAY_ID, $pre = '', $post = '') {
    $result = sslDataFind($sslData, $label);
    if ($result) {
      $result[finding] = $pre . $result[finding] . $post;
      sslCreateDiv($result, $mode);
    } else {
      //echo "The label provided is wrong!";
    }
  }

  function createEmptySSLData($id = '', $severity = 'INFO', $finding = '') {
    return ["id" => $id, "severity" => $severity, "finding" => $finding];
  }

  function generateWebPageSSL($sslData, $sslSite) {

    if ($sslData) {

      echo '<div id="testSSL">';

        echo '<div id="bilan">';
          echo '<p>' . $sslSite . ' SSL rating' . '</p>';

          echo '<div class="monitors defaultColumn">';
            sslPrint($sslData, 'overall_grade', SSL_DISPLAY_VALUE);

            // Grade Info
            $gradeInfo = createEmptySSLData('grade_cap_reason_1');
            for ($i=0; $i < 10; $i++) {
              $temp = sslDataFind($sslData, 'grade_cap_reason_' . $i);
              if ($temp) {
                $gradeInfo[finding] .= $temp[finding] . '<br>';
              }
            }
            for ($i=0; $i < 10; $i++) {
              $temp = sslDataFind($sslData, 'grade_cap_warning_' . $i);
              if ($temp) {
                $gradeInfo[finding] .= $temp[finding] . '<br>';
              }
            }
            $gradeInfo[severity] = sslDataFind($sslData, 'overall_grade')[severity];
            sslCreateDiv($gradeInfo, SSL_DISPLAY_BOTH);

            // Final score
            $score = sslDataFind($sslData, 'final_score');
            $score[finding] = 'Final Score: ' . $score[finding] . ' / 100' . '<br>';
            $score[finding] .= 'Protocol Support: ' . sslDataFind($sslData, 'protocol_support_score_weighted')[finding] . ' / 30' . '<br>';
            $score[finding] .= 'Key Exchange: ' . sslDataFind($sslData, 'key_exchange_score_weighted')[finding] . ' / 30' . '<br>';
            $score[finding] .= 'Cipher Strength: ' . sslDataFind($sslData, 'cipher_strength_score_weighted')[finding] . ' / 40';
            $score[severity] = sslDataFind($sslData, 'overall_grade')[severity];
            sslCreateDiv($score, SSL_DISPLAY_VALUE);

          echo '</div>';

        echo '</div>';

        echo '<div id="protocols">';
          echo '<p>Protocols via sockets</p>';
          echo '<div class="monitors smallColumn">';

            sslPrint($sslData, 'SSLv2', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'SSLv3', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'TLS1', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'TLS1_1', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'TLS1_2', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'TLS1_3', SSL_DISPLAY_BOTH);

            $NPN = sslDataFind($sslData, 'NPN');
            if ($NPN[finding] == 'not offered') {
              $NPN[severity] = 'OK';
            }
            sslCreateDiv($NPN, SSL_DISPLAY_BOTH);

            $ALPN = createEmptySSLData('ALPN');
            $HTTP2 = sslDataFind($sslData, 'ALPN_HTTP2');
            $HTTP1 = sslDataFind($sslData, 'ALPN');
            if ($HTTP1) {
              $ALPN[finding] .= $HTTP1[finding];
              if ($HTTP2) {
                  $ALPN[finding] .= ' | ' . $HTTP2[finding];
              }
            } else {
              if ($HTTP2) {
                  $ALPN[finding] .= $HTTP2[finding];
              }
            }

            if ($HTTP2) {
              $ALPN[severity] = 'OK';
            } else {
              $ALPN[severity] = 'LOW';
            }

            sslCreateDiv($ALPN, SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="cypherCat">';
          echo '<p>Cipher categories</p>';
          echo '<div class="monitors defaultColumn">';

            sslPrint($sslData, 'cipherlist_NULL', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_aNULL', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_EXPORT', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_LOW', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_3DES_IDEA', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_AVERAGE', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_GOOD', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipherlist_STRONG', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="serverCypherPref">';
          echo "<p>Server's cipher preferences</p>";
          echo '<div class="monitors defaultColumn">';

            sslPrint($sslData, 'cipher_order', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cipherorder_TLSv1', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cipherorder_TLSv1_1', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cipherorder_TLSv1_2', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cipherorder_TLSv1_3', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'protocol_negotiated', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cipher_negotiated', SSL_DISPLAY_BOTH);

            sslPrint($sslData, 'supportedciphers_TLSv1', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'supportedciphers_TLSv1_1', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'supportedciphers_TLSv1_2', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="forwardSecrecy">';
          echo "<p>Robust forward secrecy (FS)</p>";
          echo '<div class="monitors rowOnly">';

            $FS = sslDataFind($sslData, 'FS');
            if ($FS[severity] == 'OK') {
              $FS[finding] = sslDataFind($sslData, 'FS_ciphers')[finding];
            }
            sslCreateDiv($FS, SSL_DISPLAY_BOTH);

            //sslPrint($sslData, 'FS', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'FS_ciphers', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'FS_ECDHE_curves', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'DH_groups', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="serverDefaults">';
          echo "<p>Server defaults (Server Hello)</p>";
          echo '<div class="monitors defaultColumn">';

            sslPrint($sslData, 'TLS_extensions', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'TLS_session_ticket', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'SSL_sessionID_support', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'sessionresumption_ticket', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'sessionresumption_ID', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'TLS_timestamp', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_numbers', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_signatureAlgorithm', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_keySize', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_keyUsage', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_extKeyUsage', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="certStatus">';
          echo "<p>Certificate(s) Status</p>";
          echo '<div class="monitors defaultColumn">';
            //sslPrint($sslData, 'cert_serialNumber', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_fingerprintSHA1', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_fingerprintSHA256', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_commonName', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_commonName_wo_SNI', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_subjectAltName', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_trust', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_chain_of_trust', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_certificatePolicies_EV', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_expirationStatus', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_notBefore', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_notAfter', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_extlifeSpan', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_eTLS', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_crlDistributionPoints', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_ocspURL', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'OCSP_stapling', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_ocspRevoked', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cert_mustStapleExtension', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'DNS_CAArecord', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'certificate_transparency', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'certs_countServer', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'certs_list_ordering_problem', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cert_caIssuers', SSL_DISPLAY_BOTH);


            $cert = createEmptySSLData('Certificate');
            $certNotBefore = sslDataFind($sslData, 'cert_notBefore');
            $certNotAfter = sslDataFind($sslData, 'cert_notAfter');
            $certExpiration = sslDataFind($sslData, 'cert_expirationStatus');
            $certChain = sslDataFind($sslData, 'cert_chain_of_trust');
            $certIssuer = sslDataFind($sslData, 'cert_caIssuers');

            $cert[finding] = 'Issued: ' . $certNotBefore[finding] . '<br>';
            $cert[finding] .= 'Expiration: ' . $certNotAfter[finding] . '<br>';
            //$cert[finding] .= $certExpiration[finding] . '<br>';
            //$cert[finding] .= $certChain[finding] . '<br>';
            $cert[finding] .= 'CA: ' . $certIssuer[finding];
            $cert[severity] = $certExpiration[severity];
            sslCreateDiv($cert, SSL_DISPLAY_BOTH);

            //$interCert = createEmptySSLData('intermediate_cert');
            for ($i=0; $i < 10; $i++) {
              $cert = createEmptySSLData('intermediate_cert <#' . $i . '>');
              $certNotBefore = sslDataFind($sslData, 'intermediate_cert_notBefore <#' . $i . '>');
              $certNotAfter = sslDataFind($sslData, 'intermediate_cert_notAfter <#' . $i . '>');
              $certExpiration = sslDataFind($sslData, 'intermediate_cert_expiration <#' . $i . '>');
              $certChain = sslDataFind($sslData, 'intermediate_cert_chain <#' . $i . '>');

              if ($certNotBefore) {
                $cert[finding] = 'Issued: ' . $certNotBefore[finding] . '<br>';
                $cert[finding] .= 'Expiration: ' . $certNotAfter[finding] . '<br>';
                $cert[finding] .= 'Chain: ' . $certChain[finding];
                $cert[severity] = $certExpiration[severity];
                sslCreateDiv($cert, SSL_DISPLAY_BOTH);
              }

            }

            sslPrint($sslData, 'intermediate_cert_badOCSP', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="httpHeader">';
          echo '<p>HTTP header response at "/"</p>';
          echo '<div class="monitors defaultColumn">';

            sslPrint($sslData, 'HTTP_status_code', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'HTTP_clock_skew', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'HSTS_time', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'HSTS_subdomains', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'HSTS_preload', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'HPKP', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'banner_server', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'banner_application', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cookie_count', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'cookie_secure', SSL_DISPLAY_BOTH);
            //sslPrint($sslData, 'cookie_httponly', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'HSTS', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'banner_reverseproxy', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="securityHeader">';
          echo '<p>Security Headers</p>';
          echo '<div class="monitors defaultColumn">';

            sslPrint($sslData, 'security_headers', SSL_DISPLAY_VALUE);
            sslPrint($sslData, 'X-Frame-Options', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'X-Content-Type-Options', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'Content-Security-Policy', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'Expect-CT', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'Permissions-Policy', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'X-XSS-Protection', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'X-UA-Compatible', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'X-Content-Type-Options_multiple', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'Referrer-Policy', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'Cache-Control', SSL_DISPLAY_BOTH);
            sslPrint($sslData, 'Pragma', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="vulnerabilities">';
          echo '<p>Vulnerabilities</p>';
          echo '<div class="monitors defaultColumn">';


          sslPrint($sslData, 'heartbleed', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'CCS', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'ticketbleed', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'ROBOT', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'secure_renego', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'secure_client_renego', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'CRIME_TLS', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'BREACH', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'POODLE_SSL', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'fallback_SCSV', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'SWEET32', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'FREAK', SSL_DISPLAY_BOTH);

          $DROWN = sslDataFind($sslData, 'DROWN');
          if ($DROWN[severity] == 'OK') {
            $DROWN[finding] .= '.<br>' . sslDataFind($sslData, 'DROWN_hint')[finding];
          }
          sslCreateDiv($DROWN, SSL_DISPLAY_BOTH);

          //sslPrint($sslData, 'DROWN', SSL_DISPLAY_BOTH);
          //sslPrint($sslData, 'DROWN_hint', SSL_DISPLAY_BOTH);

          $LOGJAM = sslDataFind($sslData, 'LOGJAM');
          $LOGJAM[finding] .= ' ' . sslDataFind($sslData, 'LOGJAM-common_primes')[finding];
          sslCreateDiv($LOGJAM, SSL_DISPLAY_BOTH);

          //sslPrint($sslData, 'LOGJAM', SSL_DISPLAY_BOTH);
          //sslPrint($sslData, 'LOGJAM-common_primes', SSL_DISPLAY_BOTH);

          $BEAST = sslDataFind($sslData, 'LOGJAM');
          $BEAST[finding] .= ' ' . sslDataFind($sslData, 'LOGJAM-common_primes')[finding];
          sslCreateDiv($LOGJAM, SSL_DISPLAY_BOTH);

          sslPrint($sslData, 'BEAST', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'BEAST_CBC_TLS1', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'BEAST_CBC_SSL3', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'LUCKY13', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'winshock', SSL_DISPLAY_BOTH);
          sslPrint($sslData, 'RC4', SSL_DISPLAY_BOTH);

          echo '</div>';
        echo '</div>';

        echo '<div id="clientSimul">';
          echo '<p>Client simulations (HTTP) via sockets</p>';
          echo '<div class="monitors defaultColumn">';


          sslPrint($sslData, 'clientsimulation-android_442', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-android_500', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-android_60', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-android_70', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-android_81', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-android_90', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-android_X', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-chrome_74_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-chrome_79_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-firefox_66_win81', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-firefox_71_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_6_xp', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_8_win7', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_8_xp', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_11_win7', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_11_win81', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_11_winphone81', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-ie_11_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-edge_15_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-edge_17_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-opera_66_win10', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-safari_9_ios9', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-safari_9_osx1011', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-safari_10_osx1012', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-safari_121_ios_122', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-safari_130_osx_10146', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-apple_ats_9_ios9', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-java_6u45', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-java_7u25', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-java_8u161', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-java1102', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-java1201', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-openssl_102e', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-openssl_110l', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-openssl_111d', SSL_DISPLAY_SIMUL);
          sslPrint($sslData, 'clientsimulation-thunderbird_68_3_1', SSL_DISPLAY_SIMUL);

          echo '</div>';
        echo '</div>';

      echo '</div>';


      foreach ($sslData as $value) {
        if (! in_array($value[id], $GLOBALS['labelsAnalysed'])) {
          //echo $value[id] . ' => ' . $value[finding] . '<br>';
        }
      }

    }


  }

 ?>
