<?php

namespace UserFrosting;

use PhpOffice\PhpWord\Exception\Exception;

class SmtpMailConfigController extends \UserFrosting\BaseController
{

    protected static $_table_id = "smtp";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function getSmtpConfigTemplate()
    {

        // read smtp configuration from confoig-userfrosting.php
        $config = $this->_app->config('smtp');
        $host = $config['host'];
        $port = $config['port'];
        $auth = $config['auth'];
        $secure = $config['secure'];
        $user = $config['user'];
        $pass = $config['pass'];
        $username = $config['username'];

        $this->_app->render('config/smtp-mail-config.twig', [
            'host' => $host,
            'port' => $port,
            'auth' => $auth,
            'secure' => $secure,
            'username' => $user,
            'pass' => $pass,
            'username_sender' => $username,
        ]);
    }

    // update smtp configuration from confoig-userfrosting.php
    public function setSmtpConfigTemplate()
    {
        $post = $this->_app->request->post();

        $my_file = '../userfrosting/config-userfrosting.php';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file); //open file for writing ('w','r','a')...

        $host = $post['input_host'];
        $port = $post['input_port'];
        $auth = $post['input_auth'];
        $secure = $post['input_secure'];
        $user = $post['input_user'];
        $pass = $post['input_pass'];
        $username = $post['input_username'];

        $config = $this->_app->config('db');
        $db_host = $config['db_host'];
        $db_port = $config['db_port'];
        $db_name = $config['db_name'];
        $db_user = $config['db_user'];
        $db_pass = $config['db_pass'];
        $db_pre = $config['db_prefix'];

        $data = replace_config($host, $port, $auth, $secure, $user, $pass, $username, $db_host, $db_port, $db_name, $db_user, $db_pass, $db_pre);
        fwrite($handle, $data);
        fclose($handle);
        $this->_app->render('config/smtp-mail-config.twig', [
        ]);
    }

    public function send_email()
    {
        $post = $this->_app->request->post();
        $email = $post['email'];
        if (!isset($email)) {
            echo json_encode([
                'success' => false,
                'message' => 'Email field is required',
            ]);
            return;
        }
        $ms = $this->_app->alerts;
        $twig = $this->_app->view()->getEnvironment();
        $template = $twig->loadTemplate("mail/test-email-template.twig");
        $notification = new Notification($template);
        $notification->fromWebsite();      // Automatically sets sender and reply-to
        $notification->addEmailRecipient($email, 'test_user_name');
        try {
//            $notification->send();
            $notification->send(['subject' => 'Test Title', 'content' => 'Test Content']);

            $html = ob_get_clean();
            echo json_encode([
                'success' => true,
                'message' => '',
                'html' => $html
            ]);
        } catch (\phpmailerException $exception) {
            $html = ob_get_clean();
            echo json_encode([
                'success' => false,
                'message' => $exception->getMessage(),
                'html' => $html
            ]);
//            echo '<pre>' . print_r([4545454545, 'post' => $exception->getMessage(), 4545454545]) . '</pre>';
//            die();
            $ms->addMessageTranslated("danger", "MAIL_ERROR");
            error_log('Mailer Error: ' . $exception->errorMessage());
            //$this->_app->halt(500);
        } catch (Exception $exception) {
            $html = ob_get_clean();
            echo json_encode([
                'success' => false,
                'message' => $exception->getMessage(),
                'html' => $html
            ]);
//            echo '<pre>' . print_r(['post' => $exception->getMessage()]) . '</pre>';
//            die();
        }

    }

}

function replace_config($host, $port, $auth, $secure, $user, $pass, $username, $db_host, $db_port, $db_name, $db_user, $db_pass, $db_pre)
{
    $username = $username;
    $config = '<?php

      // Set your timezone here
      date_default_timezone_set("Asia/Jerusalem");

      // Do not send fatal errors to the response body!
      ini_set("display_errors", "off");

      /* Instantiate the Slim application */
      $app = new \UserFrosting\UserFrosting([
          "view" =>           new \Slim\Views\Twig(),
          "mode" =>           "dev"   // Set to "dev" or "production"
      ]);

      // Get file path to public directory for this website.  Is this guaranteed to work in all environments?
      $public_path = $_SERVER["DOCUMENT_ROOT"] . $app->environment()["SCRIPT_NAME"];

      // Construct public URL (e.g. "http://www.userfrosting.com/admin").  Feel free to hardcode this if you feel safer.
      $environment = $app->environment();
      $serverport = (($environment["SERVER_PORT"] == 443) or ($environment["SERVER_PORT"] == 80)) ? "" : ":" . $environment["SERVER_PORT"];
      $uri_public_root = $environment["slim.url_scheme"] . "://" . $environment["SERVER_NAME"] . $serverport . $environment["SCRIPT_NAME"];
       if ($environment["db_connection"] == null) {
        $environment["db_connection"] = "reservation_system";
      }
      /********* DEVELOPMENT SETTINGS *********/
      $app->configureMode("dev", function () use ($app, $public_path, $uri_public_root) {
          $app->config([
              "log.enable" => true,
              "debug" => false,
              "base.path"     => __DIR__,
              "templates.path" => __DIR__ . "/templates",     // This will be overridden anyway by the default theme.
              "themes.path"    =>  __DIR__ . "/templates/themes",
              "plugins.path" => __DIR__ . "/plugins",
              "schema.path" =>    __DIR__ . "/schema",
              "locales.path" =>   __DIR__ . "/locale",
              "log.path" =>   __DIR__ . "/log",
              "public.path" => $public_path,
              "js.path.relative" => "/js",
              "css.path.relative" => "/css",
              "session" => [
                  "name" => "UserFrosting",
                  "cache_limiter" => false
              ],
              "db"            =>  [
                  "db_host"  => "' . $db_host . '",
                  "db_port"  => "' . $db_port . '", // Leave blank to use the default port for your database driver (eg. 3306 for MySQL)
                  "db_name"  => "' . $db_name . '",
                  "db_user"  => "' . $db_user . '",
                  "db_pass"  => "' . $db_pass . '",
                  "db_prefix"=> "' . $db_pre . '"
              ],
              "mail" => "smtp",
              "smtp"  => [
                  "host" => "' . $host . '",
                  "port" => ' . $port . ',
                  "auth" => ' . $auth . ',
                  "secure" => "' . $secure . '",
                  "user" => ' . "'" . $user . "'" . ',
                  "pass" => ' . "'" . $pass . "'" . ',
                  "username" =>' . "'" . $username . "'" . ',
              ],
              "uri" => [
                  "public"            => $uri_public_root,
                  "js-relative"       => "/js",
                  "css-relative"      => "/css",
                  "favicon-relative"  => "/css/favicon.ico",
                  "image-relative"    => "/images"
              ],
              "user_id_guest"  => 0,
              "user_id_master" => 1,
              "theme-base"     => "default",
              "theme-root"     => "root"
          ]);
      });

      /********* PRODUCTION SETTINGS *********/
      $app->configureMode("production", function () use ($app, $public_path, $uri_public_root) {
          $app->config([
              "log.enable" => true,
              "debug" => false,
              "base.path"     => __DIR__,
              "templates.path" => __DIR__ . "/templates",
              "themes.path"    =>  __DIR__ . "/templates/themes",
              "plugins.path" => __DIR__ . "/plugins",
              "schema.path" =>    __DIR__ . "/schema",
              "locales.path" =>   __DIR__ . "/locale",
              "log.path" =>   __DIR__ . "/log",
              "public.path" => $public_path,
              "js.path.relative" => "/js",
              "css.path.relative" => "/css",
              "session" => [
                  "name" => "UserFrosting",
                  "cache_limiter" => false
              ],
              "db"            =>  [
                  "db_host"  => "' . $db_host . '",
                  "db_port"  => "' . $db_port . '", // Leave blank to use the default port for your database driver (eg. 3306 for MySQL)
                  "db_name"  => "' . $db_name . '",
                  "db_user"  => "' . $db_user . '",
                  "db_pass"  => "' . $db_pass . '",
                  "db_prefix"=> "' . $db_pre . '"
              ],
              "mail" => "smtp",
              "smtp"  => [
                  "host" => "' . $host . '",
                  "port" => ' . $port . ',
                  "auth" => ' . $auth . ',
                  "secure" => "' . $secure . '",
                  "user" => ' . "'" . $user . "'" . ',
                  "pass" => ' . "'" . $pass . "'" . ',
                  "username" =>' . "'" . $username . "'" . ',
              ],
              "uri" => [
                  "public"            => $uri_public_root,
                  "js-relative"       => "/js",
                  "css-relative"      => "/css",
                  "favicon-relative"  => "/css/favicon.ico",
                  "image-relative"    => "/images"
              ],
              "user_id_guest"  => 0,
              "user_id_master" => 1,
              "theme-base"     => "default",
              "theme-root"     => "root"
          ]);
      });

      // Set up derived configuration values
      $app->config([
          "js.path" =>  $app->config("public.path") . $app->config("js.path.relative"),
          "css.path" => $app->config("public.path") . $app->config("css.path.relative"),
          "uri" => [
              "js" =>        $app->config("uri")["public"] . $app->config("uri")["js-relative"],
              "css" =>       $app->config("uri")["public"] . $app->config("uri")["css-relative"],
              "favicon" =>   $app->config("uri")["public"] . $app->config("uri")["favicon-relative"],
              "image" =>     $app->config("uri")["public"] . $app->config("uri")["image-relative"],
          ]
      ], true);';
    return $config;
}
