
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Progress } from '@/components/ui/progress';
import { Calendar, Users, DollarSign } from 'lucide-react';

interface Agreement {
  id: string;
  title: string;
  client: string;
  creator: string;
  milestoneCount: number;
  completedMilestones: number;
  status: 'active' | 'completed' | 'disputed';
  value: string;
  dueDate: string;
}

interface AgreementCardProps {
  agreement: Agreement;
  onClick: () => void;
}

export function AgreementCard({ agreement, onClick }: AgreementCardProps) {
  const progress = (agreement.completedMilestones / agreement.milestoneCount) * 100;
  
  const statusColors = {
    active: 'bg-blue-500',
    completed: 'bg-green-500',
    disputed: 'bg-red-500',
  };

  const statusLabels = {
    active: 'Active',
    completed: 'Completed',
    disputed: 'Disputed',
  };

  return (
    <Card className="cursor-pointer hover:shadow-md transition-shadow" onClick={onClick}>
      <CardHeader>
        <div className="flex items-start justify-between">
          <div className="flex-1">
            <CardTitle className="text-lg mb-2">{agreement.title}</CardTitle>
            <div className="flex items-center gap-4 text-sm text-muted-foreground">
              <div className="flex items-center gap-1">
                <Users className="h-4 w-4" />
                {agreement.client}
              </div>
              <div className="flex items-center gap-1">
                <DollarSign className="h-4 w-4" />
                {agreement.value}
              </div>
            </div>
          </div>
          <Badge 
            className={`${statusColors[agreement.status]} text-white`}
          >
            {statusLabels[agreement.status]}
          </Badge>
        </div>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          <div>
            <div className="flex justify-between text-sm mb-2">
              <span>Progress</span>
              <span>{agreement.completedMilestones}/{agreement.milestoneCount} milestones</span>
            </div>
            <Progress value={progress} className="h-2" />
          </div>
          
          <div className="flex items-center justify-between text-sm text-muted-foreground">
            <div className="flex items-center gap-1">
              <Calendar className="h-4 w-4" />
              Due: {new Date(agreement.dueDate).toLocaleDateString()}
            </div>
            <span>{Math.round(progress)}% complete</span>
          </div>
        </div>
      </CardContent>
    </Card>
  );
}
