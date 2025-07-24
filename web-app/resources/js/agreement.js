'use strict';

import { ethers } from 'ethers';
import escrowAbi from './abi/escrow.json';

const CONTRACT_ADDRESS = '0x9E842E7bbEb02B5F278d415B30e5dBb5279A79b9';
const RPC_URL = 'https://base-sepolia.g.alchemy.com/v2/e6eIQ646n2qK6NsodvAWI';

// Helper: Format ETH
function formatEth(value) {
    return ethers.formatEther(value) + ' ETH';
}

// --- Milestone Modal Logic ---
function setupMilestoneModal(agreementId, contract, signer) {
    const addBtn = document.getElementById('add-milestone-btn');
    const modal = document.getElementById('create_milestone_modal');
    const form = document.getElementById('create-milestone-form');
    const feedback = document.getElementById('milestone-create-feedback');
    if (addBtn && modal) {
        addBtn.onclick = () => {
            form.reset();
            feedback.classList.add('hidden');
            feedback.textContent = '';
            modal.showModal();
        };
    }
    if (form) {
        form.onsubmit = async (e) => {
            e.preventDefault();
            feedback.classList.add('hidden');
            feedback.textContent = '';
            const submitBtn = form.querySelector('button[type="submit"]');

            // Ensure wallet is connected before proceeding
            if (!window.walletManager || !(await window.walletManager.ensureWalletConnected())) {
                feedback.textContent = 'Please connect your wallet first.';
                feedback.className = 'text-error bg-red-100 border border-red-200';
                feedback.classList.remove('hidden');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Adding...';
            const fd = new FormData(form);
            const title = fd.get('title');
            const description = fd.get('description');
            const value = fd.get('value');
            const dueDate = fd.get('due_date');
            if (!title || !description || !value || !dueDate) {
                feedback.textContent = 'All fields are required.';
                feedback.className = 'text-error bg-red-100 border border-red-200';
                feedback.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Add Milestone';
                return;
            }
            try {
                feedback.textContent = 'Adding milestone on-chain...';
                feedback.className = 'text-blue-700 bg-blue-100 border border-blue-200';
                feedback.classList.remove('hidden');
                const valueWei = ethers.parseEther(value);
                const dueTimestamp = Math.floor(new Date(dueDate).getTime() / 1000);
                const tx = await contract.addMilestone(agreementId, title, description, valueWei, dueTimestamp);
                feedback.textContent = 'Transaction sent, waiting for confirmation...';
                const receipt = await tx.wait();
                feedback.textContent = 'Milestone added successfully!';
                feedback.className = 'text-success bg-green-100 border border-green-200';
                setTimeout(() => {
                    modal.close();
                    feedback.classList.add('hidden');
                    feedback.textContent = '';
                }, 1200);
                // Refresh milestones
                await loadAgreementDetails(agreementId, window.walletManager?.userAddress);
            } catch (err) {
                feedback.textContent = `Failed to add milestone: ${err.message}`;
                feedback.className = 'text-error bg-red-100 border border-red-200';
                feedback.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Add Milestone';
            }
        };
    }
}

// Render agreement details
async function loadAgreementDetails(agreementId, userAddress) {
    const provider = new ethers.JsonRpcProvider(RPC_URL);
    const contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, provider);
    // Fetch agreement details from contract
    let agreement;
    try {
        agreement = await contract.getAgreement(agreementId);
    } catch (e) {
        document.getElementById('agreement-title').textContent = 'Agreement not found';
        return;
    }
    // Render agreement data
    document.getElementById('agreement-title').textContent = agreement.title || 'Untitled';
    document.getElementById('agreement-status').textContent = agreement.status;
    document.getElementById('protected-value').textContent = formatEth(agreement.value);
    document.getElementById('progress-value').textContent = agreement.progress + '%';
    document.getElementById('progress-label').textContent = `${agreement.completedMilestones} of ${agreement.totalMilestones} milestones complete`;
    document.getElementById('due-date').textContent = agreement.dueDate;
    document.getElementById('due-year').textContent = agreement.dueYear;
    document.getElementById('time-left').textContent = agreement.timeLeft;
    document.getElementById('deal-overview').textContent = agreement.overview;
    document.getElementById('client-name').textContent = agreement.client;
    document.getElementById('creator-name').textContent = agreement.creator;
    document.getElementById('contract-type').textContent = agreement.contractType;
    document.getElementById('created-date').textContent = agreement.createdAt;
    document.getElementById('escrow-status').textContent = `${formatEth(agreement.value)} protected in smart contract`;
    // Render milestones
    renderMilestones(agreement.milestones || []);
    // Setup milestone modal logic
    if (window.walletManager && window.walletManager.signer) {
        const provider = new ethers.JsonRpcProvider(RPC_URL);
        const contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, window.walletManager.signer);
        setupMilestoneModal(agreementId, contract, window.walletManager.signer);
    }
}

function renderMilestones(milestones) {
    window.currentMilestones = milestones;
    const container = document.getElementById('milestones-list');
    if (!container) return;
    if (!milestones.length) {
        container.innerHTML = '<div class="text-gray-500">No milestones yet.</div>';
        return;
    }
    container.innerHTML = milestones.map((m, i) => `
        <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <div class="font-semibold text-lg text-gray-900">${m.title}</div>
                <div class="text-gray-600 text-sm mb-2">${m.description}</div>
                <div class="text-gray-500 text-xs">Due: ${m.dueDate}</div>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium ${m.completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">
                    ${m.completed ? 'Complete' : 'Pending'}
                </span>
                <button class="ml-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold text-sm shadow hover:bg-blue-700 transition fund-btn" onclick="fundMilestone(${i})">Fund</button>
                <button class="ml-2 px-4 py-2 rounded-xl bg-green-600 text-white font-semibold text-sm shadow hover:bg-green-700 transition release-btn" onclick="releaseMilestone(${i})">Release</button>
                <button class="ml-2 px-4 py-2 rounded-xl bg-red-600 text-white font-semibold text-sm shadow hover:bg-red-700 transition" onclick="disputeMilestone(${i})">Dispute</button>
            </div>
        </div>
    `).join('');
}

// Funding and Release Milestone Logic
// Patch fundMilestone and releaseMilestone to ensure wallet connection before proceeding
window.fundMilestone = async function (idx) {
    const agreementId = window.AGREEMENT_ID;
    if (!window.walletManager || !(await window.walletManager.ensureWalletConnected())) {
        alert('Connect your wallet to fund a milestone.');
        return;
    }
    const provider = new ethers.JsonRpcProvider(RPC_URL);
    const contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, window.walletManager.signer);
    const milestones = window.currentMilestones || [];
    const milestone = milestones[idx];
    if (!milestone) return;
    const fundBtn = document.querySelectorAll('.fund-btn')[idx];
    if (fundBtn) {
        fundBtn.disabled = true;
        fundBtn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> Funding...';
    }
    try {
        const valueWei = ethers.parseEther(milestone.value.toString());
        const tx = await contract.fundMilestone(agreementId, idx, { value: valueWei });
        showMessage('Funding milestone, waiting for confirmation...', 'info');
        await tx.wait();
        showMessage('Milestone funded!', 'success');
        await loadAgreementDetails(agreementId, window.walletManager.userAddress);
    } catch (err) {
        showMessage('Failed to fund milestone: ' + err.message, 'error');
    } finally {
        if (fundBtn) {
            fundBtn.disabled = false;
            fundBtn.innerHTML = 'Fund';
        }
    }
};

window.releaseMilestone = async function (idx) {
    const agreementId = window.AGREEMENT_ID;
    if (!window.walletManager || !(await window.walletManager.ensureWalletConnected())) {
        alert('Connect your wallet to release a milestone.');
        return;
    }
    const provider = new ethers.JsonRpcProvider(RPC_URL);
    const contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, window.walletManager.signer);
    const milestones = window.currentMilestones || [];
    const milestone = milestones[idx];
    if (!milestone) return;
    const releaseBtn = document.querySelectorAll('.release-btn')[idx];
    if (releaseBtn) {
        releaseBtn.disabled = true;
        releaseBtn.innerHTML = '<span class="loading loading-spinner loading-xs"></span> Releasing...';
    }
    try {
        const tx = await contract.releaseMilestone(agreementId, idx);
        showMessage('Releasing milestone, waiting for confirmation...', 'info');
        await tx.wait();
        showMessage('Milestone released!', 'success');
        await loadAgreementDetails(agreementId, window.walletManager.userAddress);
    } catch (err) {
        showMessage('Failed to release milestone: ' + err.message, 'error');
    } finally {
        if (releaseBtn) {
            releaseBtn.disabled = false;
            releaseBtn.innerHTML = 'Release';
        }
    }
};

// Placeholder milestone action handlers
window.disputeMilestone = function (idx) {
    alert('Dispute Milestone: ' + idx);
};

// On page load, get agreementId from URL or data attribute
window.addEventListener('DOMContentLoaded', () => {
    const agreementId = window.AGREEMENT_ID || null;
    const userAddress = window.walletManager ? window.walletManager.userAddress : null;
    if (agreementId) {
        loadAgreementDetails(agreementId, userAddress);
    }
});

