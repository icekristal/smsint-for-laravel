<?php

namespace Interface;

interface SmsIntOperationInterface
{
    public function __construct();

    public function setMessage(string $message): SmsIntOperationInterface;

    public function setSenderName(string $senderName): SmsIntOperationInterface;

    public function setRecipient(string $recipient): SmsIntOperationInterface;

    public function setParams(array $params): SmsIntOperationInterface;

    public function send();
}