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

  require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
    new AjaxRequest(TYPO3.settings.ajaxUrls.render_users)
      .withQueryArguments({username: username, email: email, hideInactif: hideInactif})
      .get()
      .then(async function (response) {
        response.resolve().then(function (result){
          if(result != null){
            console.log(result)
             var table = document.getElementsByClassName('users-table')[0];
            table.style.display = "block"
            var tbody = document.getElementsByClassName('users-records')[0];
            tbody.innerHTML = ""
            for(var i = 0; i < result.length; i++ ){
              tbody.innerHTML += "<tbody> " +
                    "<tr>" +
                      "<td> </td>" +
                      "<td>" + result[i][0] + "</td>" +
                      "<td>" + result[i][1] + "</td>" +
                      "<td>" + result[i][2].date + "</td>" +
                      "<td>" + result[i][3] + "</td>" +
                    "</tr>" +
                "</tbody>"
            }
          }
        }).catch(function(e){
          console.log(e)
        });
      });
  });

}
