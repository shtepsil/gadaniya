<?php

namespace components;

use components\Debugger as d;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;

class JwtHelper
{

    protected $private_key_path;
    protected $public_key_path;

    /**
     * JwtHelper constructor.
     */
    public function __construct()
    {
        $this->public_key_path = __DIR__.'/../keys/key.pub';
        $this->private_key_path = __DIR__.'/../keys/key.pem';
    }

    /**
     * @param $user_id
     * @param \DateTime $dateTime
     * @return \Lcobucci\JWT\Token
     */
    public function generateToken($user_id, \DateTime $dateTime,$domains='')
    {
        $key = new Key(@file_get_contents($this->private_key_path));
        return (new Builder())->issuedBy($domains)
            ->permittedFor($domains)
            ->issuedAt((new \DateTime('now'))->getTimestamp())
            ->expiresAt($dateTime->getTimestamp())
            ->withClaim('user_id',$user_id)
            ->getToken(new Sha256(),$key);
    }

    /**
     * @param $token
     * @param $claim
     * @return mixed
     */
    public function getClaim($token,$claim)
    {
        $parser = new Parser();
        $token = $parser->parse($token);
        return $token->getClaim($claim);
    }

    /**
     * @param $auth_token
     * @return bool
     */
    public function validate($auth_token)
    {
        $parser = new Parser();
        $token = $parser->parse($auth_token);
        $validate = new ValidationData();
        $validate->setIssuer('http://oauth2');
        $validate->setAudience('http://oauth2');
        return $token->validate($validate);
    }

    /**
     * @param $auth_token
     * @return bool
     */
    public function verify($auth_token)
    {
        $parser = new Parser();
        $token = $parser->parse($auth_token);
        $key = new Key(@file_get_contents($this->public_key_path));
        return $token->verify(new Sha256(),$key);
    }

}//Class