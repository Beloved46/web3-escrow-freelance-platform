
import { useState } from 'react';
import { Sidebar } from '@/components/dashboard/Sidebar';
import { Topbar } from '@/components/dashboard/Topbar';
import { DashboardContent } from '@/components/dashboard/DashboardContent';
import { AgreementsList } from '@/components/dashboard/AgreementsList';
import { AgreementDetails } from '@/components/dashboard/AgreementDetails';

type DashboardView = 'home' | 'agreements' | 'profile';

export default function Dashboard() {
  const [currentView, setCurrentView] = useState<DashboardView>('home');
  const [selectedAgreementId, setSelectedAgreementId] = useState<string | null>(null);

  const handleViewChange = (view: DashboardView) => {
    setCurrentView(view);
    setSelectedAgreementId(null);
  };

  const handleAgreementSelect = (agreementId: string) => {
    setSelectedAgreementId(agreementId);
    setCurrentView('agreements');
  };

  const renderContent = () => {
    if (selectedAgreementId) {
      return (
        <AgreementDetails 
          agreementId={selectedAgreementId} 
          onBack={() => setSelectedAgreementId(null)}
        />
      );
    }

    switch (currentView) {
      case 'home':
        return <DashboardContent onViewAgreements={() => setCurrentView('agreements')} />;
      case 'agreements':
        return <AgreementsList onAgreementSelect={handleAgreementSelect} />;
      case 'profile':
        return <div className="p-6"><h2 className="text-2xl font-bold">My Profile</h2><p className="text-muted-foreground mt-2">Profile settings coming soon...</p></div>;
      default:
        return <DashboardContent onViewAgreements={() => setCurrentView('agreements')} />;
    }
  };

  return (
    <div className="min-h-screen bg-background">
      <div className="flex w-full">
        <Sidebar currentView={currentView} onViewChange={handleViewChange} />
        <div className="flex-1 flex flex-col">
          <Topbar />
          <main className="flex-1 overflow-auto">
            {renderContent()}
          </main>
        </div>
      </div>
    </div>
  );
}
