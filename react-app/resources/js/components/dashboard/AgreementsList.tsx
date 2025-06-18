
import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { AgreementCard } from '@/components/dashboard/AgreementCard';
import { Search, Filter } from 'lucide-react';

interface AgreementsListProps {
  onAgreementSelect: (agreementId: string) => void;
}

export function AgreementsList({ onAgreementSelect }: AgreementsListProps) {
  const [activeFilter, setActiveFilter] = useState<'all' | 'active' | 'completed' | 'disputed'>('all');
  const [searchTerm, setSearchTerm] = useState('');

  const agreements = [
    {
      id: '1',
      title: 'Website Redesign Project',
      client: 'TechCorp Inc.',
      creator: 'You',
      milestoneCount: 4,
      completedMilestones: 2,
      status: 'active' as const,
      value: '$5,000',
      dueDate: '2024-07-15',
    },
    {
      id: '2',
      title: 'Mobile App Development',
      client: 'StartupXYZ',
      creator: 'You',
      milestoneCount: 6,
      completedMilestones: 1,
      status: 'active' as const,
      value: '$8,000',
      dueDate: '2024-08-30',
    },
    {
      id: '3',
      title: 'Logo Design Package',
      client: 'Creative Agency',
      creator: 'You',
      milestoneCount: 3,
      completedMilestones: 3,
      status: 'completed' as const,
      value: '$1,500',
      dueDate: '2024-06-01',
    },
    {
      id: '4',
      title: 'E-commerce Platform',
      client: 'RetailCo',
      creator: 'You',
      milestoneCount: 8,
      completedMilestones: 4,
      status: 'disputed' as const,
      value: '$12,000',
      dueDate: '2024-09-15',
    },
  ];

  const filteredAgreements = agreements.filter(agreement => {
    const matchesFilter = activeFilter === 'all' || agreement.status === activeFilter;
    const matchesSearch = agreement.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         agreement.client.toLowerCase().includes(searchTerm.toLowerCase());
    return matchesFilter && matchesSearch;
  });

  const filterButtons = [
    { key: 'all', label: 'All', count: agreements.length },
    { key: 'active', label: 'Active', count: agreements.filter(a => a.status === 'active').length },
    { key: 'completed', label: 'Completed', count: agreements.filter(a => a.status === 'completed').length },
    { key: 'disputed', label: 'Disputed', count: agreements.filter(a => a.status === 'disputed').length },
  ];

  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold">Agreements</h1>
          <p className="text-muted-foreground mt-1">
            Manage your smart contracts and milestones
          </p>
        </div>
        <Button>Create New Agreement</Button>
      </div>

      <Card>
        <CardHeader>
          <div className="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
            <div className="relative flex-1 max-w-md">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Search agreements..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="pl-10"
              />
            </div>
            <div className="flex gap-2">
              {filterButtons.map((filter) => (
                <Button
                  key={filter.key}
                  variant={activeFilter === filter.key ? "default" : "outline"}
                  size="sm"
                  onClick={() => setActiveFilter(filter.key as any)}
                  className="flex items-center gap-2"
                >
                  {filter.label}
                  <Badge variant="secondary" className="text-xs">
                    {filter.count}
                  </Badge>
                </Button>
              ))}
            </div>
          </div>
        </CardHeader>
        <CardContent>
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {filteredAgreements.map((agreement) => (
              <AgreementCard
                key={agreement.id}
                agreement={agreement}
                onClick={() => onAgreementSelect(agreement.id)}
              />
            ))}
          </div>
          {filteredAgreements.length === 0 && (
            <div className="text-center py-8 text-muted-foreground">
              No agreements found matching your criteria.
            </div>
          )}
        </CardContent>
      </Card>
    </div>
  );
}
