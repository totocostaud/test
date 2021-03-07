<?php
/**
 * The webform 'confirmation' settings are 'open in a custom url with params ($beginning, $ending)
 *
 * pdf generation
 * Doc : https://www.valuebound.com/resources/blog/how-to-generate-pdf-of-html-code-drupal-8
 */
namespace Drupal\webform_recap_latribune\Controller;


use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\imce\Imce;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;

/**
 * Controller routines for imce routes.
 */
class RecapController extends ControllerBase {

  /**
   * Defines RecapController class.
   */
  public function createPdf() {

   // Get query params
    $path = \Drupal::request()->getpathInfo(); // => http://latribunepresse.local/latribune/recap/529/531
    $arg  = explode('/',$path);
    $beginning = $arg[3];
    $ending = $arg[4];

    // To get here, the visitor must be a TR reader (this is just a double check). He can upload a customized page in pdf created on the fly
    $attitude_tribune = $_SESSION['attitude_tribune'];

    if ($attitude_tribune == 'Lecteur TR') {

        // Getting the content for the customized table between the entered beginning and ending dates
        $items = get_items($beginning, $ending);

          if ($items) {

            // pdf content must be a string
            $content = '';
            $content = "<html>";
            $content .= "<head>";
            $content .= "<style>";
            $content .= "body { font-family: Arial,Helvetica,sans-serif; font-size: 0.8em;}";
            $content .= "table { width: 80%; margin-top: 50px}";
            $content .= "table, th, td {border: 1px solid #666; border-collapse: collapse;}";
            $content .= "th {text-align: center; height: 30px; vertical-align: middle; background-color: #ecd59f; }";
            $content .= "tr:nth-child(even) {background-color: #f2f2f2;}";
            $content .= "td {text-align: center; height: 30px; vertical-align: middle;}";
            $content .= "td + td + td + td + td + td {font-weight: bold;}";
            $content .= "</style>";
            $content .= "</head>";

            $content .= "<body>";
            $content .= "<div align='center'>";
            $content .= "<img src='/sites/default/files/images/logos/logo_footer_140x140.png' width='140' height='140' alt='La Tribune'>";
            $content .= "<h2>La Tribune du réseau presse du n° $beginning au n° $ending</h2>";
            $content .= "<table align='center'>";
            $content .= "<thead><tr>";
            $content .= "<th style='width: 10%;'>NUMÉRO</th>";
            $content .= "<th style='width: 22%;'>DATE de PARUTION</th>";
            $content .= "<th style='width: 18%;'>DATÉ</th>";
            $content .= "<th style='width: 17%;'>MONTANT HT<br>[€]</th>";
            $content .= "<th style='width: 17%;'>TVA<br>[2,10 %]</th>";
            $content .= "<th style='width: 27%;'>MONTANT TTC<br>[€]</th>";
            $content .= "</tr></thead>";
            $content .= "<tbody>";

            foreach ( $items as $p) {
              $id = $p->get('id')->value;
              $name = $p->get('name')->value;
              $date = $p->get('date')->value;
              $month = $p->get('month')->value;
              $year = $p->get('year')->value;
              $price_ht = $p->get('price_ht')->value;
              $tax = $p->get('tax')->value;

              $content .= "<tr>";
              $content .= "<td>$name</td>";
              $content .= "<td>" . date('d/m/Y', $p->$date) . "</td>";
              $content .= "<td>" . $month . " " . $year. "</td>";
              $content .= "<td>" . number_format($price_ht, 2). "</td>";
              $content .= "<td>" . number_format($tax, 2). "</td>";
              $content .= "<td>" . number_format($price_ht + $tax, 2). "</td>";
              $content .= "</tr>";
            }

            $content .= "</tbody>";
            $content .= "</table>";
            $content .= "</div";
            $content .= "</body>";
        // }

            $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
            $mpdf->WriteHTML($content);
            $mpdf->Output('la_tribune_numeros_parution.pdf', 'D');
            Exit;

        } else {
          $build['warning'] =  [
              '#type' => 'markup',
              '#markup' => 'Le site a rencontré un problème technique. Merci de réessayer ultérieurement.<br>',
          ];

          return $build;
        }

      }
      else // $attitude_tribune = 'Refus TR'
      {
        // notification email
        //send_recap_notification_mail($prenom, $nom, $nim, $cp, $email, $beginning, $ending);
        send_recap_notification_mail($beginning, $ending);

        $build['warning'] =  [
            '#type' => 'markup',
            '#markup' => 'Votre demande a bien été enregistrée. La Tribune vous en remercie.<br>',
        ];

        return $build;
      }
    }
}

/**
 * Custom function
 * Retreiving the prices in the database
 * Building a table and a pdf file
 *
 * @param $beginning
 * @param $ending
 */
//function get_prices($beginning, $ending) {
function get_items($beginning, $ending) {

  $result = '';

  // nota : name field contains the number of the issue
  $query = \Drupal::entityQuery('ekiosk_entity');
  $query->condition('type', 'normal');
  $query->condition('name', $beginning, '>=');
  $query->condition('name', $ending, '<=');
  $entity_ids = $query->execute();
  // kint($entity_ids);

  if ($entity_ids) {
    $issues = \Drupal::entityTypeManager()->getStorage('ekiosk_entity')->loadMultiple($entity_ids);
    //kint($issues);
  }

  return $issues;
}



/**
 * Send a mail to admin
 * allows to check the service is ok
 *
 * @param $prenom
 * @param $nom
 * @param $nim
 * @param $cp
 * @param $email
 * @param $beginning
 * @param $ending
 *
 */
// function send_recap_notification_mail($prenom, $nom, $nim, $cp, $email, $beginning, $ending) {
function send_recap_notification_mail($beginning, $ending) {

  // appel de la fonction mail pour envoi en SMTP
  $to  = 'cmarquaire@unionpresse.fr';
  $subject = "Demande de récapitulatif Union Presse";
  $message = "

<hr>
<p style='font-family:arial,verdana; font-size:16px;'>
Récapitulatif effectué pour :



début = $beginning<br>
fin = $ending
</p>";

$from  = "From:contact@unionpresse.fr\n";
$from .= "MIME-version: 1.0\n";
$from .= "Reply-To: contact@unionpresse.fr\n";
$from .= "Content-type: text/html; charset= UTF-8";

mail( $to , $subject, $message , $from );
}