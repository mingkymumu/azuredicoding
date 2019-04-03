
<html>
<head>
    <title>Analyze Sample</title>
    <script type='text/javascript' src='/js/jquery-3.3.1.min.js'></script>
    <link rel="stylesheet" type="text/css" href="/assets/themes/metro-blue/easyui.css">
    <link rel="stylesheet" type="text/css" href="/assets/themes/icon.css">
    <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/assets/js/datagrid-export.js"></script>
</head>
<body>
<script type="text/javascript">

    function ngisiData(){
        $("#responseTextArea").val('Ini cuma sekedar tes');
    }
    function processImage(stringurl) {
      
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
 
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "64216a6e8c584678a20b32ea6433dfbd";
 
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase =
            "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
 
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
 
        // Display the image.
        // var sourceImageUrl = document.getElementById("inputImage").value;
        // document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + stringurl  + '"}',
         
        })
 
        .done(function(data) {
            // Show formatted JSON on webpage.
            alert(JSON.stringify(data, null, 2))
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>
<div id="cc" class="easyui-layout" style="width:1024px;height:800px;">
    <div data-options="region:'north',title:'North Title',split:true" style="height:800px;">
    <div style="padding:50px">
    <form action="fileupload.php" enctype="multipart/form-data" method="post">
    Select image :
    <input type="file" name="file"><br/>
    <input type="submit" value="Upload" name="Submit1"> <br/>
    </div>
<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


$connectionString = "DefaultEndpointsProtocol=https;AccountName=webappdicoding;AccountKey=mxkB+bJQO4L/+KDpTCOLHE9KHi8H2rk3FHO8a3Ve4KTyAzSTwn12zmRen8INMXhtlL5JpxNdscVh0vsyD68XkA==";

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);

if(isset($_POST['Submit1']))
{
$createContainerOptions = new CreateContainerOptions();
$filetoupload = $_FILES["file"]["name"];   

$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// Set container metadata.
$createContainerOptions->addMetaData("key1", "value1");
$createContainerOptions->addMetaData("key2", "value2");

$containerName = "blobgambar";

if(move_uploaded_file($_FILES["file"]["tmp_name"], $filetoupload)) 
{
    try {
        // Create container.
        // $blobClient->createContainer($containerName, $createContainerOptions);

        // Getting local file so that we can upload it to Azure
        $myfile = fopen($filetoupload, "r") or die("Unable to open file!");
        fclose($myfile);
        
      
        
        $content = fopen($filetoupload, "r");

        //Upload blob
        $blobClient->createBlockBlob($containerName, $filetoupload, $content);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "Upload File Success";
        // List blobs.
        //$listBlobsOptions = new ListBlobsOptions();
        // $listBlobsOptions->setPrefix("HelloWorld");

      

        // do{
        //     $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
        //     foreach ($result->getBlobs() as $blob)
        //     {
        //         // echo $blob->getName().": ".$blob->getUrl()."<br />";
        //         echo "<img id=".$blob->getUrl()." src=".$blob->getUrl()." height=200 width=300 />";
        //         echo "<button onclick='ngisiData()'>Analyze image</button>";

        //     }
        
        //     $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        // } while($result->getContinuationToken());
        // echo "<br />";

        // Get blob.
        // echo "This is the content of the blob uploaded: ";
        // $blob = $blobClient->getBlob($containerName, $fileToUpload);
        // fpassthru($blob->getContentStream());
        // echo "<br />";
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
} 
else 
{

    try{
        // Delete container.
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "No File Selected".PHP_EOL;
        echo $_GET["containerName"].PHP_EOL;
        echo "<br />";
        $blobClient->deleteContainer($_GET["containerName"]);
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
}
} 


?>

</form>


</div>
    
</div>






</body>
</html>

