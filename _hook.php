<?php
/**
 * This script is for easily deploying updates to Github Jekyll repos to your local server. It will automatically git clone or
 * git pull in your repo directory every time an update is pushed to your $BRANCH (configured below) and generate the static website in $LOCAL_DST.
 *
 *
 * INSTRUCTIONS:
 * 1. Edit the variables below
 * 2. Upload this script to your server somewhere it can be publicly accessed
 * 3. Make sure the apache user owns files under $LOCAL_ROOT (sudo chown www-data:www-data $LOCAL_ROOT)
 * 4. Go into your Github Repo > Settings > Service Hooks > WebHook URLs and add the public URL
 *    (e.g., http://example.com/webhook.php)
 *
 **/

// Set Variables
$LOCAL_ROOT         = "/path/to/repo/parent/directory";
$LOCAL_REPO_NAME    = "REPO_NAME";
$LOCAL_DST_NAME     = "DST_NAME";
$LOCAL_REPO         = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
$LOCAL_DST          = "{$LOCAL_ROOT}/{$LOCAL_DST_NAME}";
$REMOTE_REPO        = "https://github.com/username/reponame.git";
$BRANCH             = "master";
$SECRET             = "secret";

$secret = $SECRET;

$headers = getallheaders();
$hubSignature = $headers['X-Hub-Signature'];

list($algo, $hash) = explode('=', $hubSignature, 2);

$payload = file_get_contents('php://input');
$data    = json_decode($payload);

$payloadHash = hash_hmac($algo, $payload, $secret);

if ($hash !== $payloadHash) {
    die('Bad secret');
}

if ( isset($data) ) {
    // Only respond to POST requests from Github

    if( file_exists($LOCAL_REPO) ) {

        // If there is already a repo, just run a git pull to grab the latest changes
        exec("cd {$LOCAL_REPO} && git checkout {$BRANCH} . && git pull");

    } else {

        // If the repo does not exist, then clone it into the parent directory
        exec("cd {$LOCAL_ROOT} && git clone {$REMOTE_REPO} && git checkout {$BRANCH}");

    }

    if ( !file_exists($LOCAL_REPO) ) {

        die(date('l jS \of F Y h:i:s A') . ": " . "Git repo does not exsit and cannot be created");

    }

    exec("cd {$LOCAL_REPO} && jekyll build", $output, $retval);

    if ( $retval != 0 ) {
        die($output);
    }

    exec("cp -fR {$LOCAL_REPO}/_site {$LOCAL_DST}");

    die(date('l jS \of F Y h:i:s A') . ": " . "done.");
}

header("HTTP/1.0 404 Not Found");

?>