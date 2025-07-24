require("@nomicfoundation/hardhat-toolbox");
require("@nomicfoundation/hardhat-ignition-ethers");
require("dotenv").config();

/** @type import('hardhat/config').HardhatUserConfig */
module.exports = {
  solidity: {
    version: "0.8.28", 
    settings: {
      optimizer: {
        enabled: true,
        runs: 200,
      },
    },
  },
  networks: {
    baseSepolia: {
      url: `https://base-sepolia.g.alchemy.com/v2/e6eIQ646n2qK6NsodvAWI`,
      accounts: [process.env.PRIVATE_KEY],
      chainId: 84532,
    },
    // baseSepolia: {
    //   url: "https://sepolia.base.org",  // Official Base Sepolia RPC
    //   accounts: process.env.PRIVATE_KEY ? [process.env.PRIVATE_KEY] : [],
    //   chainId: 84532,
    //   gasPrice: 1000000000, // 1 gwei
    //   networkCheckTimeout: 300000,
    //   timeout: 300000,
    //   httpHeaders: {
    //     "Accept-Encoding": "gzip, deflate, br",
    //     "Content-Type": "application/json",
    //     "Cache-Control": "no-cache",
    //     "Accept": "application/json",
    //   },
    //   verify: {
    //     timeout: 300000,
    //   },
    //   httpRetryCodes: [408, 413, 429, 500, 502, 503, 504, 521, 522, 524],
    //   httpRetryCount: 10,
    //   httpRequestTimeout: 300000,
    //   connectionTimeout: 300000,
    // },
    // Base Sepolia Testnet (using official endpoint)
    // Base Mainnet (for later)
    base: {
      url: "https://mainnet.base.org",
      accounts: process.env.PRIVATE_KEY ? [process.env.PRIVATE_KEY] : [],
      chainId: 8453,
      gasPrice: 1000000000,
    },
    // Local development
    localhost: {
      url: "http://127.0.0.1:8545",
      chainId: 31337,
    },
  },
  etherscan: {
    apiKey: {
      baseSepolia: process.env.BASESCAN_API_KEY || "",
      base: process.env.BASESCAN_API_KEY || "",
    },
    customChains: [
      {
        network: "baseSepolia",
        chainId: 84532,
        urls: {
          apiURL: "https://api-sepolia.basescan.org/api",
          browserURL: "https://sepolia.basescan.org/",
        },
      },
      {
        network: "base",
        chainId: 8453,
        urls: {
          apiURL: "https://api.basescan.org/api",
          browserURL: "https://basescan.org/",
        },
      },
    ],
  },
  gasReporter: {
    enabled: process.env.REPORT_GAS !== undefined,
    currency: "USD",
  },
  sourcify: {
    enabled: true
  },
};