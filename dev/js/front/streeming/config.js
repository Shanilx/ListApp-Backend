;(function(window) {

 
  /**
   * Add parameter to url search
   * for switch users groups
   *
   * Possible options:
   * https://examples.com?users=prod
   * https://examples.com?users=dev
   * https://examples.com - for qa by default
   */
  var usersQuery = _getQueryVar('users');

  var CONFIG = {
    debug: true,
    webrtc: {
      answerTimeInterval: 30,
      dialingTimeInterval: 5,
      disconnectTimeInterval: 30,
      statsReportTimeInterval: 5
    }
  };

  /**
   * QBAppDefault for qa and dev
   * QBAppProd for production
   */
  var QBAppProd = {
    appId: 52388,
    authKey: '5C8dHpawaUGtED8',
    authSecret: 'pejdPuMOPOKHycK'
  },
  QBAppDefault = {
    appId: 52388,
    authKey: '5C8dHpawaUGtED8',
    authSecret: 'pejdPuMOPOKHycK'
  };

  /** set QBApp */
  var QBApp = usersQuery === 'qa' ? QBAppDefault : usersQuery === 'dev' ? QBAppDefault : QBAppProd;

  QBUsersProd=[];
  // QBUsersProd = [
  //   {
  //     id: 16275482,
  //     login: 't@gmail.com',
  //     password: 'Fit123Quick',
  //     full_name: 'taq',
  //     colour: 'FD8209'
  //   },
  //   {
  //     id: 16354248,
  //     login: 'beta@gmail.com',
  //     password: 'Fit123Quick',
  //     full_name: 'Beta',
  //     colour: 'FD8209'
  //   },
  //   {
  //     id: 16267372,
  //     login: 'aditi@gmail.com',
  //     password: 'Fit123Quick',
  //     full_name: 'User 3',
  //     colour: 'F81480'
  //   },
  //   {
  //     id: 16248200,
  //     login: 'jack@gmail.com',
  //     password: 'Fit123Quick',
  //     full_name: 'User 4',
  //     colour: '39A345'
  //   }
  // ];

  /** set QBUsers */
  var QBUsers = usersQuery === 'qa' ? QBUsersQA : usersQuery === 'dev' ? QBUsersDev : QBUsersProd;
  var MESSAGES = {
    'login': 'Login as any user on this computer and another user on another computer.',
    'create_session': 'Creating a session...',
    'connect': 'Connecting...',
    'connect_error': 'Something wrong with connect to chat. Check internet connection or user info and trying again.',
    'login_as': 'Logged in as ',
    'title_login': 'Choose a user to login with:',
    'title_callee': 'Choose users to call:',
    'calling': 'Calling...',
    'webrtc_not_avaible': 'WebRTC is not available in your browser',
    'no_internet': 'Please check your Internet connection and try again'
  };

  /**
   * PRIVATE
   */
  /**
   * [_getQueryVar get value of key from search string of url]
   * @param  {[string]} q [name of query]
   * @return {[string]}   [value of query]
   */
  function _getQueryVar(q) { 
    var query = window.location.search.substring(1),
        vars = query.split("&"),
        answ = false;

    vars.forEach(function(el, i){
      var pair = el.split('=');

      if(pair[0] === q) {
        answ = pair[1];
        }
    });
    return answ;
  }

  /**
   * set configuration variables in global
   */
  window.QBApp = QBApp;
  window.CONFIG = CONFIG;
  window.QBUsers = QBUsers;
  window.MESSAGES = MESSAGES;
}(window));
