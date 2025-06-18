
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { FileText, TrendingUp, Clock, CheckCircle } from 'lucide-react';

interface DashboardContentProps {
  onViewAgreements: () => void;
}

export function DashboardContent({ onViewAgreements }: DashboardContentProps) {
  const stats = [
    {
      title: 'Active Agreements',
      value: '3',
      description: 'Currently ongoing',
      icon: FileText,
      color: 'text-blue-600',
    },
    {
      title: 'Total Value',
      value: '$12,500',
      description: 'Across all agreements',
      icon: TrendingUp,
      color: 'text-green-600',
    },
    {
      title: 'Pending Milestones',
      value: '5',
      description: 'Awaiting action',
      icon: Clock,
      color: 'text-orange-600',
    },
    {
      title: 'Completed',
      value: '12',
      description: 'Successfully finished',
      icon: CheckCircle,
      color: 'text-emerald-600',
    },
  ];

  const recentActivity = [
    {
      id: '1',
      title: 'Website Redesign Project',
      client: 'TechCorp Inc.',
      action: 'Milestone 2 approved',
      time: '2 hours ago',
      status: 'approved',
    },
    {
      id: '2',
      title: 'Mobile App Development',
      client: 'StartupXYZ',
      action: 'Work submitted for review',
      time: '1 day ago',
      status: 'pending',
    },
    {
      id: '3',
      title: 'Logo Design Package',
      client: 'Creative Agency',
      action: 'Payment released',
      time: '3 days ago',
      status: 'completed',
    },
  ];

  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-bold">Welcome back!</h1>
          <p className="text-muted-foreground mt-1">
            Here's what's happening with your agreements today.
          </p>
        </div>
        <Button onClick={onViewAgreements}>
          View All Agreements
        </Button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat) => (
          <Card key={stat.title}>
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium">
                {stat.title}
              </CardTitle>
              <stat.icon className={`h-4 w-4 ${stat.color}`} />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stat.value}</div>
              <p className="text-xs text-muted-foreground">
                {stat.description}
              </p>
            </CardContent>
          </Card>
        ))}
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Recent Activity</CardTitle>
          <CardDescription>
            Latest updates from your agreements
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            {recentActivity.map((activity) => (
              <div key={activity.id} className="flex items-center justify-between p-4 border rounded-lg">
                <div className="flex-1">
                  <h4 className="font-medium">{activity.title}</h4>
                  <p className="text-sm text-muted-foreground">
                    Client: {activity.client}
                  </p>
                  <p className="text-sm font-medium mt-1">{activity.action}</p>
                </div>
                <div className="flex items-center space-x-3">
                  <Badge 
                    variant={
                      activity.status === 'completed' ? 'default' :
                      activity.status === 'approved' ? 'secondary' : 'outline'
                    }
                  >
                    {activity.status}
                  </Badge>
                  <span className="text-xs text-muted-foreground">
                    {activity.time}
                  </span>
                </div>
              </div>
            ))}
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
