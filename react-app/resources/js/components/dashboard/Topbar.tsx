
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Bell, Settings } from 'lucide-react';

export function Topbar() {
  return (
    <header className="h-16 bg-card border-b border-border px-6 flex items-center justify-between">
      <div className="flex items-center space-x-4">
        <h2 className="text-lg font-semibold">Dashboard</h2>
      </div>
      
      <div className="flex items-center space-x-4">
        <Badge variant="outline" className="px-3 py-1 font-mono text-xs">
          0x1234...5678
        </Badge>
        
        <Button variant="ghost" size="icon">
          <Bell className="h-5 w-5" />
        </Button>
        
        <Button variant="ghost" size="icon">
          <Settings className="h-5 w-5" />
        </Button>
      </div>
    </header>
  );
}
