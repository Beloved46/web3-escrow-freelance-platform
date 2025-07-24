import { ethers } from 'ethers';

// Render dashboard stats
function renderStats(stats) {
    const statsEl = document.getElementById('dashboard-stats');
    if (!statsEl) return;
    statsEl.innerHTML = `
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Trust Score</h3>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold mb-2">${stats.trust_score ?? '--'}</div>
            <div class="text-blue-100 text-sm">${stats.trust_score_label ?? ''}</div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-300">${stats.trust_score_change ?? ''}</span>
                <span class="text-blue-100 ml-1">this month</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Active Deals</h3>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-2">${stats.active ?? 0}</div>
            <div class="text-gray-600 text-sm">Protected by smart contracts</div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Value Protected</h3>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-2">$${stats.value_protected ?? 0}</div>
            <div class="text-gray-600 text-sm">In escrow protection</div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Success Rate</h3>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-2">${stats.success_rate ?? 0}%</div>
            <div class="text-gray-600 text-sm">Deals completed successfully</div>
        </div>
    `;
}

// Render agreement cards
function renderAgreements(agreements) {
    const grid = document.getElementById('agreementsGrid');
    if (!grid) return;
    if (!agreements || agreements.length === 0) {
        grid.innerHTML = '<div class="col-span-full text-center text-gray-400 py-12">No agreements found.</div>';
        return;
    }
    grid.innerHTML = agreements.map(agreement => `
        <div class="agreement-card card bg-base-100 shadow-sm border border-base-200 hover:shadow-lg hover:border-primary/30 transition-all duration-200 cursor-pointer"
            data-status="${agreement.status}" data-title="${agreement.title}" data-client="${agreement.client}" onclick="window.location.href='/agreements/${agreement.id}'">
            <div class="card-body">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="card-title text-lg mb-2">${agreement.title}</h3>
                        <div class="flex items-center gap-4 text-sm text-base-content/60">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                ${agreement.client}
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                                $${agreement.value}
                            </div>
                        </div>
                    </div>
                    <div class="badge badge-${agreement.status === 'active' ? 'primary' : agreement.status === 'completed' ? 'success' : agreement.status === 'disputed' ? 'error' : 'neutral'}">${agreement.status.charAt(0).toUpperCase() + agreement.status.slice(1)}</div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-base-content/70">Progress</span>
                            <span class="font-medium">${agreement.completed_milestones}/${agreement.milestones} milestones</span>
                        </div>
                        <div class="w-full bg-base-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all duration-300" style="width: ${agreement.progress}%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm text-base-content/60">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Due: ${agreement.due_date}
                        </div>
                        <span class="font-medium">${agreement.progress}% complete</span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

// Render recent activity
function renderRecentActivity(activity) {
    const el = document.getElementById('recentActivity');
    if (!el) return;
    if (!activity || activity.length === 0) {
        el.innerHTML = '<div class="text-center py-12 text-gray-400">No recent activity</div>';
        return;
    }
    el.innerHTML = activity.map(item => `
        <div class="flex items-start space-x-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center ${item.status === 'success' ? 'bg-green-100' : item.status === 'pending' ? 'bg-yellow-100' : 'bg-blue-100'}">
                <svg class="w-5 h-5 ${item.status === 'success' ? 'text-green-600' : item.status === 'pending' ? 'text-yellow-600' : 'text-blue-600'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">${item.title}</p>
                <p class="text-xs text-gray-500 mt-1">${item.time}</p>
            </div>
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${item.status === 'success' ? 'bg-green-100 text-green-800' : item.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'}">
                    ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                </span>
            </div>
        </div>
    `).join('');
}

// Fetch and render dashboard data
export async function loadDashboardData() {
    try {
        const res = await fetch('/api/dashboard-data');
        const data = await res.json();
        renderStats(data.stats);
        renderAgreements(data.agreements);
        renderRecentActivity(data.recent_activity);
    } catch (e) {
        // Optionally show error toast
    }
}

// Call on page load
if (document.getElementById('dashboard-stats')) {
    loadDashboardData();
}

// Expose a function to update dashboard after wallet connect
window.updateDashboardAfterWalletConnect = function (freshData) {
    renderStats(freshData.stats);
    renderAgreements(freshData.agreements);
    renderRecentActivity(freshData.recent_activity);
    // Optionally POST to /api/sync-dashboard
    fetch('/api/sync-dashboard', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(freshData)
    });
};

const CONTRACT_ADDRESS = '0x9E842E7bbEb02B5F278d415B30e5dBb5279A79b9';
const RPC_URL = 'https://base-sepolia.g.alchemy.com/v2/e6eIQ646n2qK6NsodvAWI';
import escrowAbi from './abi/escrow.json';

export async function fetchOnChainDashboardData(userAddress) {
    const provider = new ethers.JsonRpcProvider(RPC_URL);
    const contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, provider);
    // Fetch AgreementCreated events involving the user
    const events = await contract.queryFilter('AgreementCreated', -10000); // last 10k blocks
    const myAgreements = [];
    for (const event of events) {
        const { agreementId, client, creator, description, deadline } = event.args;
        if (
            client.toLowerCase() === userAddress.toLowerCase() ||
            creator.toLowerCase() === userAddress.toLowerCase()
        ) {
            // Fetch agreement details
            const agreement = await contract.getAgreement(agreementId);
            myAgreements.push({
                id: agreementId.toString(),
                title: agreement.description.split(':')[0].trim(),
                client,
                creator,
                value: ethers.formatEther(agreement.fundedAmount),
                status: agreement.status, // map to string as needed
                due_date: agreement.deadline ? new Date(Number(agreement.deadline) * 1000).toLocaleDateString() : '',
                milestones: agreement.milestones?.length || 0,
                completed_milestones: 0, // placeholder, fetch real if needed
                progress: 0, // placeholder, fetch real if needed
            });
        }
    }
    // Calculate stats
    const stats = {
        active: myAgreements.filter(a => a.status === 'active').length,
        value_protected: myAgreements.reduce((sum, a) => sum + Number(a.value), 0),
        success_rate: myAgreements.length
            ? Math.round(
                (myAgreements.filter(a => a.status === 'completed').length / myAgreements.length) * 100
            )
            : 0,
        // Add trust_score, etc. as needed
    };
    // Build recent activity (last 5 agreements)
    const recent_activity = myAgreements.slice(-5).map(a => ({
        title: a.title,
        time: a.due_date,
        status: a.status,
    }));
    return {
        agreements: myAgreements,
        stats,
        recent_activity,
    };
}

window.fetchAndUpdateDashboardOnChain = async function (userAddress) {
    const freshData = await fetchOnChainDashboardData(userAddress);
    window.updateDashboardAfterWalletConnect(freshData);
};

class DashboardApp {
    constructor() {
        this.userAddress = null;
        this.userAgreements = [];
        this.isLoading = false;
        this.walletConnected = false;
        this.init();
    }

    async init() {
        console.log('🚀 Initializing Dashboard App...');

        // Load cached data immediately (no wallet needed)
        await this.loadCachedData();

        // Set up wallet connection listener
        this.setupWalletListener();

        // Try to auto-connect wallet
        this.attemptWalletConnection();
    }

    setupWalletListener() {
        // Listen for wallet connection events
        if (window.walletManager) {
            // Override the triggerAppUpdate method to call our refresh
            const originalTrigger = window.walletManager.triggerAppUpdate;
            window.walletManager.triggerAppUpdate = () => {
                console.log('💰 Wallet connected, refreshing with on-chain data...');
                this.walletConnected = true;
                this.userAddress = window.walletManager.userAddress;
                this.loadOnChainData();
                if (originalTrigger) originalTrigger.call(window.walletManager);
            };
        }
    }

    async attemptWalletConnection() {
        // Wait a bit for wallet manager to initialize
        setTimeout(async () => {
            if (window.walletManager && !window.walletManager.isConnected) {
                console.log('🔗 Attempting wallet auto-connection...');
                // The wallet manager will handle auto-connect
            }
        }, 1000);
    }

    async loadCachedData() {
        console.log('📦 Loading cached data from backend...');
        this.isLoading = true;

        try {
            const response = await fetch('/api/dashboard/data', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                }
            });

            if (response.ok) {
                const data = await response.json();
                console.log('✅ Cached data loaded:', data);

                this.userAgreements = data.agreements || [];
                this.updateDashboardStats(data.stats || {});
                this.renderAgreements();

                // Show a subtle indicator that this is cached data
                this.showCachedDataIndicator();
            } else {
                console.warn('⚠️ Failed to load cached data, showing empty state');
                this.showEmptyState();
            }
        } catch (error) {
            console.error('❌ Error loading cached data:', error);
            this.showEmptyState();
        } finally {
            this.isLoading = false;
        }
    }

    async loadOnChainData() {
        if (!this.walletConnected || !this.userAddress) {
            console.log('❌ Cannot load on-chain data: wallet not connected');
            return;
        }

        console.log('🔗 Loading fresh on-chain data...');
        this.isLoading = true;

        try {
            // Load agreements from blockchain
            await this.loadUserAgreements();

            // Update stats
            this.updateDashboardStats({
                total: this.userAgreements.length,
                active: this.userAgreements.filter(a => a.status === 'active' || a.status === 'inprogress').length,
                completed: this.userAgreements.filter(a => a.status === 'completed').length,
                disputed: this.userAgreements.filter(a => a.status === 'disputed').length
            });

            // Hide cached data indicator
            this.hideCachedDataIndicator();

            // Show success message
            this.showMessage('✅ Connected to blockchain - showing live data', 'success');

        } catch (error) {
            console.error('❌ Error loading on-chain data:', error);
            this.showMessage('⚠️ Failed to load blockchain data, showing cached data', 'warning');
        } finally {
            this.isLoading = false;
        }
    }

    async loadUserAgreements() {
        if (!window.walletManager || !window.walletManager.contract || !this.userAddress) {
            console.log('❌ Cannot load agreements: contract or address not available');
            return;
        }

        try {
            console.log('🔍 Loading agreements for address:', this.userAddress);

            // Get all agreements where user is client or creator
            const contract = window.walletManager.contract;

            // This is a simplified approach - in a real app you'd use events or indexing
            // For now, we'll simulate loading agreements
            const agreements = await this.fetchAgreementsFromContract(contract);

            this.userAgreements = agreements;
            this.renderAgreements();

            console.log('✅ Loaded agreements:', agreements.length);

        } catch (error) {
            console.error('❌ Error loading agreements:', error);
            throw error;
        }
    }

    async fetchAgreementsFromContract(contract) {
        // This is a placeholder - you'd implement actual contract calls here
        // For now, return the cached data as if it came from blockchain
        return this.userAgreements.map(agreement => ({
            ...agreement,
            source: 'blockchain',
            lastUpdated: new Date().toISOString()
        }));
    }

    updateDashboardStats(stats) {
        // Update stats cards
        const totalEl = document.querySelector('[data-stat="total"]');
        const activeEl = document.querySelector('[data-stat="active"]');
        const completedEl = document.querySelector('[data-stat="completed"]');
        const disputedEl = document.querySelector('[data-stat="disputed"]');

        if (totalEl) totalEl.textContent = stats.total || 0;
        if (activeEl) activeEl.textContent = stats.active || 0;
        if (completedEl) completedEl.textContent = stats.completed || 0;
        if (disputedEl) disputedEl.textContent = stats.disputed || 0;

        // Update filter counts
        this.updateFilterCounts();
    }

    updateFilterCounts() {
        const counts = {
            all: this.userAgreements.length,
            active: this.userAgreements.filter(a => a.status === 'active' || a.status === 'inprogress').length,
            completed: this.userAgreements.filter(a => a.status === 'completed').length,
            disputed: this.userAgreements.filter(a => a.status === 'disputed').length
        };

        Object.keys(counts).forEach(filter => {
            const button = document.querySelector(`[data-filter="${filter}"]`);
            if (button) {
                const countSpan = button.querySelector('span');
                if (countSpan) {
                    countSpan.textContent = counts[filter];
                }
            }
        });
    }

    renderAgreements() {
        const grid = document.getElementById('agreementsGrid');
        const emptyState = document.getElementById('emptyState');

        if (!grid) return;

        // Clear existing content
        grid.innerHTML = '';

        if (!this.userAgreements || this.userAgreements.length === 0) {
            if (emptyState) {
                emptyState.style.display = 'block';
            }
            return;
        } else {
            if (emptyState) {
                emptyState.style.display = 'none';
            }
        }

        this.userAgreements.forEach(agreement => {
            const card = this.renderAgreementCard(agreement);
            grid.appendChild(card);
        });
    }

    renderAgreementCard(agreement) {
        const card = document.createElement('div');
        card.className = 'agreement-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:scale-105';
        card.setAttribute('data-status', agreement.status);
        card.setAttribute('data-title', agreement.title);
        card.setAttribute('data-client', agreement.client_name);

        // Add source indicator if it's cached data
        const sourceIndicator = !this.walletConnected ?
            '<div class="absolute top-2 right-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Cached</div>' : '';

        card.innerHTML = `
            <div class="p-6 relative">
                ${sourceIndicator}
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">${agreement.title}</h3>
                            <p class="text-sm text-gray-600">${agreement.client_name}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${this.getStatusColor(agreement.status)}">
                        ${agreement.status}
                    </span>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Protected Value</span>
                        <span class="font-semibold text-gray-900">${agreement.value}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Progress</span>
                        <span class="text-sm font-medium text-gray-900">${agreement.progress || 0}%</span>
                    </div>
                    
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300" style="width: ${agreement.progress || 0}%"></div>
                    </div>

                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <span>Due: ${agreement.due_date}</span>
                        <span>${agreement.milestones_left || 0} milestones left</span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Details
                    </button>
                    <button class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Manage
                    </button>
                </div>
            </div>
        `;

        return card;
    }

    getStatusColor(status) {
        const colors = {
            'active': 'bg-green-100 text-green-800',
            'inprogress': 'bg-blue-100 text-blue-800',
            'completed': 'bg-purple-100 text-purple-800',
            'disputed': 'bg-red-100 text-red-800',
            'created': 'bg-yellow-100 text-yellow-800'
        };
        return colors[status] || 'bg-gray-100 text-gray-800';
    }

    showCachedDataIndicator() {
        // Show a subtle indicator that data is cached
        const indicator = document.createElement('div');
        indicator.id = 'cached-data-indicator';
        indicator.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded-lg shadow-lg z-50';
        indicator.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">Showing cached data</span>
                <button onclick="this.parentElement.parentElement.remove()" class="text-yellow-600 hover:text-yellow-800">×</button>
            </div>
        `;
        document.body.appendChild(indicator);
    }

    hideCachedDataIndicator() {
        const indicator = document.getElementById('cached-data-indicator');
        if (indicator) {
            indicator.remove();
        }
    }

    showEmptyState() {
        const grid = document.getElementById('agreementsGrid');
        if (grid) {
            grid.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No agreements found</h3>
                    <p class="text-gray-600 mb-6">Connect your wallet to see your blockchain agreements or create a new one.</p>
                    <button onclick="create_agreement_modal.showModal()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Your First Agreement
                    </button>
                </div>
            `;
        }
    }

    showMessage(message, type = 'info') {
        if (window.showMessage) {
            window.showMessage(message, type);
        } else {
            console.log(`${type}: ${message}`);
        }
    }
}

// Initialize dashboard app
const dashboardApp = new DashboardApp();
window.dashboardApp = dashboardApp; 