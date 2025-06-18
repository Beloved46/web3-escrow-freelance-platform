
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { FileText, User, LogOut } from 'lucide-react';
import { cn } from '@/lib/utils';

type DashboardView = 'home' | 'agreements' | 'profile';

interface SidebarProps {
  currentView: DashboardView;
  onViewChange: (view: DashboardView) => void;
}

export function Sidebar({ currentView, onViewChange }: SidebarProps) {
  const menuItems = [
    {
      id: 'home' as DashboardView,
      label: 'Dashboard',
      icon: FileText,
      badge: null,
    },
    {
      id: 'agreements' as DashboardView,
      label: 'Agreements',
      icon: FileText,
      badge: '3',
    },
    {
      id: 'profile' as DashboardView,
      label: 'My Profile',
      icon: User,
      badge: null,
    },
  ];

  return (
    <div className="w-64 bg-card border-r border-border h-screen flex flex-col">
      <div className="p-6 border-b border-border">
        <h1 className="text-2xl font-bold text-primary">Bondr</h1>
        <p className="text-sm text-muted-foreground mt-1">Smart Agreements</p>
      </div>
      
      <nav className="flex-1 p-4 space-y-2">
        {menuItems.map((item) => (
          <Button
            key={item.id}
            variant={currentView === item.id ? "default" : "ghost"}
            className={cn(
              "w-full justify-start h-12",
              currentView === item.id && "bg-primary text-primary-foreground"
            )}
            onClick={() => onViewChange(item.id)}
          >
            <item.icon className="mr-3 h-5 w-5" />
            <span className="flex-1 text-left">{item.label}</span>
            {item.badge && (
              <Badge variant="secondary" className="ml-2">
                {item.badge}
              </Badge>
            )}
          </Button>
        ))}
      </nav>

      <div className="p-4 border-t border-border">
        <Button variant="ghost" className="w-full justify-start h-12 text-muted-foreground hover:text-destructive">
          <LogOut className="mr-3 h-5 w-5" />
          Logout
        </Button>
      </div>
    </div>
  );
}
