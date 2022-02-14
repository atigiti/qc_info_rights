/**
 * Module: TYPO3/CMS/QcInfoRights/Filter
 *
 * @exports TYPO3/CMS/QcInforights/Filter
 */
function submitFilter(e){
  alert('hello world')
  require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
    new AjaxRequest(TYPO3.settings.ajaxUrls.render_users)
      .withQueryArguments({})
      .get()
      .then(async function (response) {
        /*response.resolve().then(function (result){
          if(result != null){
            console.log(result)
          }
        }).catch(function(e){
          console.log("Error")
          console.log(e)
        });*/
        console.log(response)
      });
  });

}
