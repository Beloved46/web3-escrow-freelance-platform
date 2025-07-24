'use strict';

import { ethers } from 'ethers';

import { abi as escrowAbi } from './abi/escrow.json'

const CONTRACT_ADDRESS = '0xC80b3735646e9c6a3b15e4AAFf81369fc8E1e7Aa'; // Replace with your contract address

let provider;
let signer;
let contract;

export async function connect() {
  // All window.ethereum and MetaMask logic removed for WalletConnect-only flow
}
