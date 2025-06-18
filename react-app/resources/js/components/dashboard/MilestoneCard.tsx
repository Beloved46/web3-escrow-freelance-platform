
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { UploadBox } from '@/components/dashboard/UploadBox';
import { Calendar, DollarSign, CheckCircle, Clock, AlertCircle } from 'lucide-react';

interface Milestone {
  id: string;
  name: string;
  description: string;
  status: 'pending' | 'funded' | 'released';
  value: string;
  dueDate: string;
  submissionDate?: string;
}

interface MilestoneCardProps {
  milestone: Milestone;
  milestoneNumber: number;
}

export function MilestoneCard({ milestone, milestoneNumber }: MilestoneCardProps) {
  const statusConfig = {
    pending: {
      icon: Clock,
      color: 'bg-orange-500',
      label: 'Pending',
      actions: ['Submit Work'],
    },
    funded: {
      icon: AlertCircle,
      color: 'bg-blue-500',
      label: 'Funded',
      actions: ['Approve', 'Request Changes'],
    },
    released: {
      icon: CheckCircle,
      color: 'bg-green-500',
      label: 'Released',
      actions: [],
    },
  };

  const config = statusConfig[milestone.status];
  const StatusIcon = config.icon;

  return (
    <Card className="w-full">
      <CardHeader>
        <div className="flex items-start justify-between">
          <div className="flex-1">
            <CardTitle className="flex items-center gap-3">
              <span className="bg-muted text-muted-foreground px-2 py-1 rounded text-sm font-medium">
                Milestone {milestoneNumber}
              </span>
              {milestone.name}
            </CardTitle>
            <p className="text-muted-foreground mt-2">{milestone.description}</p>
          </div>
          <Badge className={`${config.color} text-white flex items-center gap-1`}>
            <StatusIcon className="h-3 w-3" />
            {config.label}
          </Badge>
        </div>
      </CardHeader>
      <CardContent>
        <div className="space-y-4">
          <div className="flex items-center gap-6 text-sm text-muted-foreground">
            <div className="flex items-center gap-1">
              <DollarSign className="h-4 w-4" />
              {milestone.value}
            </div>
            <div className="flex items-center gap-1">
              <Calendar className="h-4 w-4" />
              Due: {new Date(milestone.dueDate).toLocaleDateString()}
            </div>
            {milestone.submissionDate && (
              <div className="flex items-center gap-1">
                <CheckCircle className="h-4 w-4" />
                Submitted: {new Date(milestone.submissionDate).toLocaleDateString()}
              </div>
            )}
          </div>

          {milestone.status === 'pending' && (
            <UploadBox />
          )}

          {config.actions.length > 0 && (
            <div className="flex gap-2 pt-2">
              {config.actions.map((action) => (
                <Button
                  key={action}
                  variant={action === 'Approve' ? 'default' : 'outline'}
                  size="sm"
                >
                  {action}
                </Button>
              ))}
            </div>
          )}
        </div>
      </CardContent>
    </Card>
  );
}
