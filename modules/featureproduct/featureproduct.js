
function getNextCatgory(id)
{
//    var baseDir = 'http://localhost/visit/';
    var baseDir = 'http://www.visitortrip.com/';

    //alert(baseDir + "modules/featureproduct/getCategory.php");
    var categoryId = id.split("->");
    $.ajax({
        type: 'POST',
        headers: {"cache-control": "no-cache"},
        url: baseDir + "modules/featureproduct/getCategory.php",
        async: true,
        cache: false,
        dataType: "json",
        data: 'ajax=true'
                + '&categoryId=' + categoryId[0]
                + '&allow_refresh=1',
        success: function (jsonData) {
            // alert(jsonData)
            if (jsonData.length > 0) {
                $("#childParent").empty();
                //   $("#childParent").append("<option></option>");
                for (var i = 0; i < jsonData.length; i++)
                {
                    $("#childParent").append("<option>" + jsonData[i] + "</option>");
                    //console.log(); 
                }
            }
        }
    });

}