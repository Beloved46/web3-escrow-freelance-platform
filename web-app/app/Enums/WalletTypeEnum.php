<?php

namespace App\Enums;

enum WalletTypeEnum :string
{
    case METAMASK = 'metamask';
    case WALLET_CONNECT = 'walletconnect';
    case COINBASE_WALLET = 'coinbase_wallet';
    case TRUST_WALLET = 'trust_wallet';
    case LEDGER = 'ledger';
    case TALLY = 'tally';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::METAMASK => 'MetaMask',
            self::WALLET_CONNECT => 'WalletConnect',
            self::COINBASE_WALLET => 'Coinbase Wallet',
            self::TRUST_WALLET => 'Trust Wallet',
            self::LEDGER => 'Ledger',
            self::TALLY => 'Tally',
            self::OTHER => 'Other',
        };
    }
    public function icon(): string
    {
        return match ($this) {
            self::METAMASK => 'metamask',
            self::WALLET_CONNECT => 'walletconnect',
            self::COINBASE_WALLET => 'coinbase-wallet',
            self::TRUST_WALLET => 'trust-wallet',
            self::LEDGER => 'ledger',
            self::TALLY => 'tally',
            self::OTHER => 'other-wallet',
        };
    }
    public function isWeb3(): bool
    {
        return in_array($this, [
            self::METAMASK,
            self::WALLET_CONNECT,
            self::COINBASE_WALLET,
            self::TRUST_WALLET,
            self::LEDGER,
            self::TALLY,
        ]);
    }
    public function isMobile(): bool
    {
        return in_array($this, [
            self::TRUST_WALLET,
            self::COINBASE_WALLET,
        ]);
    }
    public function isDesktop(): bool
    {
        return in_array($this, [
            self::METAMASK,
            self::WALLET_CONNECT,
            self::LEDGER,
            self::TALLY,
        ]);
    }
}
