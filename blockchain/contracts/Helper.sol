// SPDX-License-Identifier: UNLICENSED
pragma solidity ^0.8.17;

contract Helper {
    function getCurrentBlockTimestamp() public view returns (uint256) {
        return block.timestamp;
    }

    function getCurrentBlockNumber() public view returns (uint256) {
        return block.number;
    }

    function getCurrentBlockDifficulty() public view returns (uint256) {
        return block.prevrandao;
    }

    function getCurrentBlockGasLimit() public view returns (uint256) {
        return block.gaslimit;
    }
    
}