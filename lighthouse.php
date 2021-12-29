<?php

  define("LH_DISPLAY_SCORE", 2);
  define("LH_DISPLAY_AUDIT", 3);

  function getSeverityFromScore($result) {

    //$result[scoreDisplayMode] posibilities:
    //  binary 0 or 1
    //  numeric float [0,1]
    //  informative
    //  notApplicable
    //  manual

    if ($result[scoreDisplayMode] == 'informative') {return 'INFO';}
    if ($result[scoreDisplayMode] == 'manual') {return 'WARN';}
    if ($result[scoreDisplayMode] == 'notApplicable') {return 'NONAPP';}
    $score = $result[score] * 100;

    if ($score < 50) {
      return 'HIGH';
    } elseif ($score < 90) {
      return 'LOW';
    } elseif ($score) {
      return 'OK';
    }
  }

  function getTitleFromID($result) {

    switch ($result[id]) {
      // Accessibility
      case 'aaaaaaaaaaaaaaaaa': return 'aaaaaaaaaaaaaaaaaaaa';
    }

    //return strip_tags($result[title]);
    $title = $result[title];
    $title = str_replace("`", "", $title);
    $title = str_replace("<", "&#60;", $title);
    $title = str_replace(">", "&#62;", $title);
    return $title;
  }

  function getLabelDescription($label) {

  }

  function sslCreateDiv($result, $mode = LH_DISPLAY_ID) {

    //echo '<div class=' . getSeverityFromScore($result) . '>';
    echo '<div class="' . getSeverityFromScore($result) . '" onclick="openSidePanel(\'' . getTitleFromID($result) . '\', \'' . getSeverityFromScore($result) . '\', \'' . "Description" . '\', \'' . "Problem" . '\')">';

    switch ($mode) {
      case LH_DISPLAY_SCORE:
        echo '<p class="title">' . getTitleFromID($result) . '</p>';
        echo '<p>' . $result[score] * 100 . ' / 100</p>';
        break;

      case LH_DISPLAY_AUDIT:
        //if ($result[scoreDisplayMode] == 'notApplicable') {return;}
        //echo '<p class="title">' . getTitleFromID($result) . ' (' . $result[score] . ')' . '</p>';
        if (isset($result[displayValue])) {
          echo '<p class="title">' . getTitleFromID($result) . '</p>';
          echo '<p>' . $result[displayValue] . '</p>';
        } else {
          echo '<p>' . getTitleFromID($result) . '</p>';
        }
        break;

      default:
        echo '<p>aaaaaaaaaaaaaaaaa</p>';
        break;
    }

    echo '</div>';
  }

  function generateCategorie($lhData, $categorie, $subCategorie, $title) {
    echo '<div>';
      echo '<p>' . $title . '</p>';
        echo '<div class="monitors defaultColumn">';
          foreach ($lhData[categories][$categorie][auditRefs] as $auditRef) {
            if ($auditRef[group] == $subCategorie || ($subCategorie == NULL && !isset($auditRef[group]))) {
              $audit = $lhData[audits][$auditRef[id]];
              sslCreateDiv($audit, LH_DISPLAY_AUDIT);
            }
          }
      echo '</div>';
    echo '</div>';
  }

  function generateWebPageLH($lhData) {

    if ($lhData) {
      echo '<div id="lighthouse">';

        echo '<div id="bilan">';
          echo '<p>' . $lhData[finalUrl] . ' WebDev rating' . '</p>';
          echo '<div class="monitors defaultColumn">';

            $overallScore = 0.0;
            $overallScore += $lhData[categories][performance][score]      * 0.3;
            $overallScore += $lhData[categories][accessibility][score]    * 0.2;
            $overallScore += $lhData[categories]['best-practices'][score] * 0.2;
            $overallScore += $lhData[categories][seo][score]              * 0.2;
            $overallScore += $lhData[categories][pwa][score]              * 0.1;
            $overallScore = round($overallScore * 100) / 100;

            $overallGrade = ['title' => 'Overall Grade', 'id' => 'overall_grade', 'score' => $overallScore];

            sslCreateDiv($overallGrade, LH_DISPLAY_SCORE);
            sslCreateDiv($lhData[categories][performance], LH_DISPLAY_SCORE);
            sslCreateDiv($lhData[categories][accessibility], LH_DISPLAY_SCORE);
            sslCreateDiv($lhData[categories]['best-practices'], LH_DISPLAY_SCORE);
            sslCreateDiv($lhData[categories][seo], LH_DISPLAY_SCORE);
            sslCreateDiv($lhData[categories][pwa], LH_DISPLAY_SCORE);

          echo '</div>';
        echo '</div>';

        generateCategorie($lhData, 'performance', 'metrics', 'Performance - Metrics');
        generateCategorie($lhData, 'performance', 'load-opportunities', 'Performance - Load Opportunities');
        generateCategorie($lhData, 'performance', 'diagnostics', 'Performance - Diagnostics');
        generateCategorie($lhData, 'performance', 'budgets', 'Performance - Budgets');
        generateCategorie($lhData, 'performance', NULL, 'Performance - Others');

        generateCategorie($lhData, 'accessibility', 'a11y-navigation', 'Accessibility - Navigation');
        generateCategorie($lhData, 'accessibility', 'a11y-aria', 'Accessibility - Navigation');
        generateCategorie($lhData, 'accessibility', 'a11y-names-labels', 'Accessibility - Names & Labels');
        generateCategorie($lhData, 'accessibility', 'a11y-color-contrast', 'Accessibility - Color & Contrast');
        generateCategorie($lhData, 'accessibility', 'a11y-tables-lists', 'Accessibility - Tables & Lists');
        generateCategorie($lhData, 'accessibility', 'a11y-language', 'Accessibility - Language');
        generateCategorie($lhData, 'accessibility', 'a11y-best-practices', 'Accessibility - Best Practices');
        generateCategorie($lhData, 'accessibility', 'a11y-audio-video', 'Accessibility - Audio & Video');
        generateCategorie($lhData, 'accessibility', NULL, 'Accessibility - Others');

        generateCategorie($lhData, 'best-practices', 'best-practices-general', 'Best practices - General');
        generateCategorie($lhData, 'best-practices', 'best-practices-ux', 'Best practices - UX');
        generateCategorie($lhData, 'best-practices', 'best-practices-browser-compat', 'Best practices - Browser compatibility');
        generateCategorie($lhData, 'best-practices', 'best-practices-trust-safety', 'Best practices - Trust & Safety');
        //generateCategorie($lhData, 'best-practices', NULL, 'Best practices - Others');

        generateCategorie($lhData, 'seo', 'seo-content', 'SEO - Content');
        generateCategorie($lhData, 'seo', 'seo-mobile', 'SEO - Mobile');
        generateCategorie($lhData, 'seo', 'seo-crawl', 'SEO - Crawl');
        generateCategorie($lhData, 'seo', NULL, 'SEO - Others');

        generateCategorie($lhData, 'pwa', 'pwa-installable', 'Progressive Web App - Installable');
        generateCategorie($lhData, 'pwa', 'pwa-optimized', 'Progressive Web App - Optimized');
        generateCategorie($lhData, 'pwa', 'pwa-fast-reliable', 'Progressive Web App - Fast & Reliable');
        generateCategorie($lhData, 'pwa', NULL, 'Progressive Web App - Others');

        echo '</div>';
    }

  }

 ?>
