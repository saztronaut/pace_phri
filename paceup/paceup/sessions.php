<?php
/**
 *=-----------------------------------------------------------=
 * nuke_session
 *=-----------------------------------------------------------=
 * This function completely destroys a session and all of its
 * data after we have logged a user out of our system.  In
 * addition to destroying the session data, we destroy the session
 * cookie and also make sure that $_SESSION is unset.
 * Needs to be included at the top of every page of the application.
 */
define('USER_AGENT_SALT', 'RandomString');

function nuke_session()
{
  session_destroy();
  setcookie(session_name(), '', time() - 3600);
  $_SESSION[] = array();
}

// One of these sessions can last 60 minutes
ini_set('session.gc_maxlifetime', 3600);
session_start();


// Try to prevent session fixation by ensuring that we created the session id.
if (!isset($_SESSION['created'])) {
  session_regenerate_id();
  $_SESSION['created'] = TRUE;
}

/**
 * Try to limit the damage from a compromised session id by
 * saving a hash of the User-Agent: string with another value.
 */
if (!isset($_SESSION['user_agent'])) {
  // create a hash user agent and a string to store in session data and user cookies
  $_SESSION['user_agent'] = md5($_SERVER['HTTP_USER_AGENT'] . USER_AGENT_SALT);
  setcookie('srn', $_SESSION['user_agent'], 0);
} else {
  // verify the user agent matches the session data and cookies.
  if ($_SESSION['user_agent'] != md5($_SERVER['HTTP_USER_AGENT'] . USER_AGENT_SALT)
      || (isset($_COOKIE['srn'])
          && $_COOKIE['srn'] != $_SESSION['user_agent'])) {
    // Possible Security Violation. Tell the user what happened and refuse to continue.
    throw new SessionCompromisedException();
  }
}

?>