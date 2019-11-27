<?php
/**
 * Vend plugin for Craft Commerce
 *
 * Connect your Craft Commerce store to Vend POS.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2019 Angell & Co
 */

namespace angellco\vend\services;

use angellco\vend\oauth\providers\Vend as OauthProvider;
use craft\base\Component;
use craft\helpers\UrlHelper;
use venveo\oauthclient\models\Token as OauthToken;
use venveo\oauthclient\Plugin as OauthPlugin;

/**
 * Api service.
 *
 * @author    Angell & Co
 * @package   Vend
 * @since     2.0.0
 */
class Api extends Component
{
    // Public Properties
    // =========================================================================

    /**
     * @var OauthPlugin
     */
    public $oauthPlugin;

    /**
     * @var mixed|OauthToken
     */
    public $oauthToken;

    /**
     * @var OauthProvider
     */
    public $oauthProvider;

    // Public Methods
    // =========================================================================

    /**
     * Api constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        // Cache the OAuth Plugin
        $this->oauthPlugin = OauthPlugin::$plugin;

        // Try and get a valid token and cache the results
        try {
            $tokens = $this->oauthPlugin->credentials->getValidTokensForAppAndUser('vend');

            if ($tokens) {
                /** @var OauthToken oauthToken */
                $this->oauthToken = $tokens[0];
                /** @var OauthProvider $provider */
                $this->oauthProvider = $this->oauthToken->getApp()->getProviderInstance()->getConfiguredProvider();
            }
        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * Gets and authenticated response and returns the parsed result.
     *
     * @param       $uri
     * @param array $params
     *
     * @return mixed
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getResponse($uri, $params = [])
    {
        $url = $this->getPreparedUrl($uri, $params);
        $request = $this->oauthProvider->getAuthenticatedRequest('GET', $url, $this->oauthToken);
        return $this->oauthProvider->getParsedResponse($request);
    }

    /**
     * Returns a prepared URL for the API for a given URI and optional
     * query parameters
     *
     * @param       $uri
     * @param array $params
     *
     * @return string
     */
    public function getPreparedUrl($uri, $params = []): string
    {
        $url = $this->oauthProvider->getApiUrl($uri);

        if ($params) {
            $query = UrlHelper::buildQuery($params);
            $url .= '?'.$query;
        }

        return $url;
    }

}
