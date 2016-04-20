# ShockBlast's NETWORK Status page
[Live Demo - ShockBlast Status Page!](http://status.shockblast.net/)

This script serves as a STATUS page, it helps to check via AJAX if a pre-selected IP address or Domain is returning a 200 OK, therefore online and reachable.

You can have:
- an infinite list of hosts and ip addresses 
- define different ports 
- define the seconds/minutes the script should refresh and check again the domain


This is where you should enter your list of sites to check:

        $servers = array(
        
            'ShockBlast' => array( // Service Name
                'ip' => 'shockblast.net', // ip address or domain
                'port' => 80, // port; 80 = http & 443 = https
                'info' => 'ShockBlast', // Name / Description (useless field)
                'purpose' => 'Main' // Description
            )
        
        );
