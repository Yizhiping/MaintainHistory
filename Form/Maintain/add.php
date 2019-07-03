<?php
/**
 * Created by PhpStorm.
 * User: Ping_yi
 * Date: 2019/7/3
 * Time: 16:52
 */

$shift = __get('shift');
$line = __get('line');
$model = __get('model');
$station = __get('station');
$device = __get('device');
$errCode = __get('errCode');
$errDesc = __get('errDesc');
$rootCause = __get('rootCause');
$causeAnalysis = __get('causeAnalysis');
$action = __get('action');
$result = __get('result');
$owner = __get('owner');

?>
<div id="divMaintainAdd">
<?php
include("Form/Maintain/Form.php");
?>
</div>
