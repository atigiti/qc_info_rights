/**
 * Module: TYPO3/CMS/QcInfoRights/Filter
 *
 * @exports TYPO3/CMS/QcInforights/Filter
 */
function submitFilter(e){
  e.preventDefault()
  // get filter data
  var username = document.getElementById('user_SET_username').value;
  var email = document.getElementById('user_SET_mail').value;
  var hideInactif = document.getElementById('user_SET_hideInactif');

  console.log(username)
  console.log(email)
  console.log(hideInactif.checked)
  require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
    new AjaxRequest(TYPO3.settings.ajaxUrls.render_users)
      .withQueryArguments({username: username, email: email, hideInactif: hideInactif})
      .get()
      .then(async function (response) {
        response.resolve().then(function (result){
          if(result != null){
            console.log(result)
          }
        }).catch(function(e){
          console.log(e)
        });
      });
  });

}
