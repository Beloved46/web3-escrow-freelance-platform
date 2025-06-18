
import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { MilestoneCard } from '@/components/dashboard/MilestoneCard';
import { ArrowLeft, Users, Calendar, DollarSign, AlertTriangle } from 'lucide-react';

interface AgreementDetailsProps {
  agreementId: string;
  onBack: () => void;
}

export function AgreementDetails({ agreementId, onBack }: AgreementDetailsProps) {
  // Mock data - in a real app, this would be fetched based on agreementId
  const agreement = {
    id: agreementId,
    title: 'Website Redesign Project',
    client: 'TechCorp Inc.',
    creator: 'John Doe (You)',
    status: 'active' as const,
    value: '$5,000',
    startDate: '2024-06-01',
    dueDate: '2024-07-15',
    description: 'Complete redesign of the corporate website including new branding, responsive design, and improved user experience.',
  };

  const milestones = [
    {
      id: '1',
      name: 'Initial Design Mockups',
      description: 'Create wireframes and initial design concepts',
      status: 'released' as const,
      value: '$1,000',
      dueDate: '2024-06-15',
      submissionDate: '2024-06-14',
    },
    {
      id: '2',
      name: 'Frontend Development',
      description: 'Develop responsive frontend with modern UI components',
      status: 'funded' as const,
      value: '$2,000',
      dueDate: '2024-06-30',
      submissionDate: '2024-06-28',
    },
    {
      id: '3',
      name: 'Backend Integration',
      description: 'Integrate with existing backend systems and APIs',
      status: 'pending' as const,
      value: '$1,500',
      dueDate: '2024-07-10',
    },
    {
      id: '4',
      name: 'Testing & Deployment',
      description: 'Final testing, bug fixes, and production deployment',
      status: 'pending' as const,
      value: '$500',
      dueDate: '2024-07-15',
    },
  ];

  const statusColors = {
    active: 'bg-blue-500',
    completed: 'bg-green-500',
    disputed: 'bg-red-500',
  };

  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center gap-4">
        <Button variant="ghost" size="icon" onClick={onBack}>
          <ArrowLeft className="h-5 w-5" />
        </Button>
        <div className="flex-1">
          <h1 className="text-3xl font-bold">{agreement.title}</h1>
          <p className="text-muted-foreground mt-1">
            Agreement details and milestone tracking
          </p>
        </div>
        <Badge className={`${statusColors[agreement.status]} text-white px-4 py-2`}>
          {agreement.status.charAt(0).toUpperCase() + agreement.status.slice(1)}
        </Badge>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Agreement Overview</CardTitle>
          <CardDescription>{agreement.description}</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div className="flex items-center gap-3">
              <Users className="h-5 w-5 text-muted-foreground" />
              <div>
                <p className="text-sm text-muted-foreground">Client</p>
                <p className="font-medium">{agreement.client}</p>
              </div>
            </div>
            
            <div className="flex items-center gap-3">
              <Users className="h-5 w-5 text-muted-foreground" />
              <div>
                <p className="text-sm text-muted-foreground">Creator</p>
                <p className="font-medium">{agreement.creator}</p>
              </div>
            </div>

            <div className="flex items-center gap-3">
              <DollarSign className="h-5 w-5 text-muted-foreground" />
              <div>
                <p className="text-sm text-muted-foreground">Total Value</p>
                <p className="font-medium">{agreement.value}</p>
              </div>
            </div>

            <div className="flex items-center gap-3">
              <Calendar className="h-5 w-5 text-muted-foreground" />
              <div>
                <p className="text-sm text-muted-foreground">Due Date</p>
                <p className="font-medium">{new Date(agreement.dueDate).toLocaleDateString()}</p>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <div className="flex items-center justify-between">
            <div>
              <CardTitle>Milestones</CardTitle>
              <CardDescription>
                Track progress and manage deliverables
              </CardDescription>
            </div>
            <Button variant="outline">
              <AlertTriangle className="h-4 w-4 mr-2" />
              Raise Dispute
            </Button>
          </div>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            {milestones.map((milestone, index) => (
              <MilestoneCard
                key={milestone.id}
                milestone={milestone}
                milestoneNumber={index + 1}
              />
            ))}
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
