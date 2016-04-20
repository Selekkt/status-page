<?php
/*
 *  WTF: ShockBlast STATUS
 *  VER: 1.0.0
 *  URL: https://status.ShockBlast.net/
 *
 *  DEV: https://Selekkt.dk/
 *  GET: https://Selekkt.dk/git/status-page
 *  
 *  GNU General Public Licence v3.0
 *  https://Selekkt.dk/git/status-page/blob/master/LICENSE
 */

$title = "ShockBlast Network Status"; // Website Title
$refresh = "30000"; // how often script should check domain > in milliseconds.

$servers = array(

    'ShockBlast' => array( // Service Name
        'ip' => 'shockblast.net', // ip address or domain
        'port' => 80, // port; 80 = http & 443 = https
        'info' => 'ShockBlast', // Name / Description (useless field)
        'purpose' => 'Main' // Description
    ),
    'Shop' => array(
        'ip' => 'shopblast.net',
        'port' => 443,
        'info' => 'Shop',
        'purpose' => 'ShopBlast'
    ),
    'img' => array(
        'ip' => 'img.shockblast.net',
        'port' => 80,
        'info' => 'images CDN',
        'purpose' => 'images'
    )

);

if (isset($_GET['host'])) {
    $host = $_GET['host'];


    if (isset($servers[$host])) {
        header('Content-Type: application/json');

        $return = array(
            'status' => test($servers[$host])
        );

        echo json_encode($return);
        exit;
    } else {
        header("HTTP/1.1 404 Not Found");
    }
}

$names = array();
foreach ($servers as $name => $info) {
    $names[$name] = md5($name);
}
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <title><?php echo $title; ?></title>

        <meta name="description" content="Welcome to ShockBlast&#39;s home for real-time data on system performance.">
        <meta name="robots" content="index, follow">

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
    </head>
    <body>

        <div class="container">
            <h1><?php echo $title; ?></h1>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Service</th>
                        <th>Host</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($servers as $name => $server): ?>

                        <tr id="<?php echo md5($name); ?>">
                            <td><i class="icon-spinner icon-spin icon-large"></i></td>
                            <td class="name"><?php echo $name; ?></td>
                            <td><?php echo $server['info']; ?></td>
                            <td><?php echo $server['purpose']; ?></td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
            <p><a href="https://www.ShockBlast.net/">ShockBlast</a> &bull; <a href="https://twitter.com/ShckBlst">@ShckBlst</a> &bull; <a href="http://log.shockblast.net/">Log</a></p>
        </div>

        <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
        
        <script type="text/javascript">
            function test(host, hash) {
                var request;
                request = $.ajax({
                    url: "<?php echo basename(__FILE__); ?>",
                    type: "get",
                    data: { host: host },
                    beforeSend: function () { $('#' + hash).children().children().css({'visibility': 'visible'}); }
                });

                request.done(function (response, textStatus, jqXHR) {
                    var status = response.status;
                    var statusClass;
                    if (status) { statusClass = 'success'; } else { statusClass = 'error'; }
                    $('#' + hash).removeClass('success error').addClass(statusClass);
                });

                request.fail(function (jqXHR, textStatus, errorThrown) { console.error("The following error occured: " + textStatus, errorThrown); });
                request.always(function () { $('#' + hash).children().children().css({'visibility': 'hidden'}); })
            }

            $(document).ready(function () {
                var servers = <?php echo json_encode($names); ?>;
                var server, hash;

                for (var key in servers) {
                    server = key;
                    hash = servers[key];

                    test(server, hash);
                    (function loop(server, hash) {
                        setTimeout(function () {
                            test(server, hash);
                            loop(server, hash);
                        }, <?php echo $refresh; ?>);
                    })(server, hash);
                }

            });
        </script>

    </body>
</html>

<?php
function test($server) {
    $socket = @fsockopen($server['ip'], $server['port'], $errorNo, $errorStr, 3);
    if ($errorNo == 0) {
        return true;
    } else {
        return false;
    }
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
?>
