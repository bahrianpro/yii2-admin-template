<?php

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Sign in to start your session', 'p');

    }

    // demonstrates `amLoggedInAs` method
//    public function internalLoginById(\FunctionalTester $I)
//    {
//        $I->amLoggedInAs(100);
//        $I->amOnPage('/');
//        $I->see('Logout (admin)');
//    }

    // demonstrates `amLoggedInAs` method
//    public function internalLoginByInstance(\FunctionalTester $I)
//    {
//        $I->amLoggedInAs(\app\models\User::findByUsername('admin'));
//        $I->amOnPage('/');
//        $I->see('Logout (admin)');
//    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->see('Login to your account failed.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'Login[email]' => 'admin@somewhere.com',
            'Login[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect email or password.');
        $I->see('Login to your account failed.');
    }
    
    public function emailValidate(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'Login[email]' => 'no-email',
            'Login[password]' => 'wrong',
        ]);
        $I->see('Email is not a valid email address.');
    }

//    public function loginSuccessfully(\FunctionalTester $I)
//    {
//        $I->submitForm('#login-form', [
//            'LoginForm[username]' => 'admin',
//            'LoginForm[password]' => 'admin',
//        ]);
//        $I->see('Logout (admin)');
//        $I->dontSeeElement('form#login-form');              
//    }
}