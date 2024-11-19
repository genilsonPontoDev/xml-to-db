<?php
namespace Aws\ControlTower;

use Aws\AwsClient;

/**
 * This client is used to interact with the **AWS Control Tower** service.
 * @method \Aws\Result createLandingZone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createLandingZoneAsync(array $args = [])
 * @method \Aws\Result deleteLandingZone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteLandingZoneAsync(array $args = [])
 * @method \Aws\Result disableBaseline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disableBaselineAsync(array $args = [])
 * @method \Aws\Result disableControl(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disableControlAsync(array $args = [])
 * @method \Aws\Result enableBaseline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise enableBaselineAsync(array $args = [])
 * @method \Aws\Result enableControl(array $args = [])
 * @method \GuzzleHttp\Promise\Promise enableControlAsync(array $args = [])
 * @method \Aws\Result getBaseline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getBaselineAsync(array $args = [])
 * @method \Aws\Result getBaselineOperation(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getBaselineOperationAsync(array $args = [])
 * @method \Aws\Result getControlOperation(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getControlOperationAsync(array $args = [])
 * @method \Aws\Result getEnabledBaseline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getEnabledBaselineAsync(array $args = [])
 * @method \Aws\Result getEnabledControl(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getEnabledControlAsync(array $args = [])
 * @method \Aws\Result getLandingZone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getLandingZoneAsync(array $args = [])
 * @method \Aws\Result getLandingZoneOperation(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getLandingZoneOperationAsync(array $args = [])
 * @method \Aws\Result listBaselines(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listBaselinesAsync(array $args = [])
 * @method \Aws\Result listControlOperations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listControlOperationsAsync(array $args = [])
 * @method \Aws\Result listEnabledBaselines(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listEnabledBaselinesAsync(array $args = [])
 * @method \Aws\Result listEnabledControls(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listEnabledControlsAsync(array $args = [])
 * @method \Aws\Result listLandingZoneOperations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listLandingZoneOperationsAsync(array $args = [])
 * @method \Aws\Result listLandingZones(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listLandingZonesAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result resetEnabledBaseline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resetEnabledBaselineAsync(array $args = [])
 * @method \Aws\Result resetEnabledControl(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resetEnabledControlAsync(array $args = [])
 * @method \Aws\Result resetLandingZone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resetLandingZoneAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateEnabledBaseline(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateEnabledBaselineAsync(array $args = [])
 * @method \Aws\Result updateEnabledControl(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateEnabledControlAsync(array $args = [])
 * @method \Aws\Result updateLandingZone(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateLandingZoneAsync(array $args = [])
 */
class ControlTowerClient extends AwsClient {}