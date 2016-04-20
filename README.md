# ShockBlast's NETWORK Status page
[Live Demo - ShockBlast Status Page!](http://status.shockblast.net/)

This script serves as a STATUS page, it helps you to check via AJAX (without refreshing the whole page) if a pre-selected IP address or domain is giving a 200 OK response.

You can:
- have an infinite list of hosts and/or ip addresses 
- define different ports 
- define the seconds/minutes the script should refresh and check the domain/IP


This is where and how you should enter your list of sites to get checked:

        $servers = array(
        
            'ShockBlast' => array(              // Service Name
                'ip' => 'shockblast.net',       // IP address or Domain
                'port' => 80,                   // port: i.e. 80 = http & 443 = https
                'info' => 'ShockBlast',         // Use for Name / Description [useless field]
                'purpose' => 'Main'             // Description
            )
        
        );
