
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Shield, Zap, Users, ArrowRight } from "lucide-react";
import { Link } from "@inertiajs/react";

const Index = () => {
  const features = [
    {
      icon: Shield,
      title: "Smart Contract Security",
      description: "Blockchain-powered agreements with built-in escrow and dispute resolution.",
    },
    {
      icon: Zap,
      title: "Milestone-Based Payments",
      description: "Automated payments released when milestones are completed and approved.",
    },
    {
      icon: Users,
      title: "Multi-Party Agreements",
      description: "Support for complex agreements with multiple stakeholders and roles.",
    },
  ];

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
      {/* Navigation */}
      <nav className="container mx-auto px-6 py-4">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <div className="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
              <span className="text-white font-bold">B</span>
            </div>
            <span className="text-2xl font-bold text-primary">Bondr</span>
          </div>
          <div className="flex items-center space-x-4">
            <Button variant="ghost">About</Button>
            <Button variant="ghost">Features</Button>
            <Button variant="outline">Login</Button>
            <Button asChild>
              <Link to="/dashboard">Dashboard</Link>
            </Button>
          </div>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="container mx-auto px-6 py-20 text-center">
        <Badge variant="secondary" className="mb-4">
          Smart Agreements Platform
        </Badge>
        <h1 className="text-5xl font-bold text-gray-900 mb-6">
          Secure Agreements with
          <span className="text-primary"> Smart Contracts</span>
        </h1>
        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
          Create milestone-based agreements with automatic escrow, dispute resolution, 
          and transparent progress tracking. Built on blockchain for maximum security.
        </p>
        <div className="flex gap-4 justify-center">
          <Button size="lg" asChild>
            <Link to="/dashboard" className="flex items-center gap-2">
              Get Started <ArrowRight className="h-4 w-4" />
            </Link>
          </Button>
          <Button variant="outline" size="lg">
            Learn More
          </Button>
        </div>
      </section>

      {/* Features Section */}
      <section className="container mx-auto px-6 py-20">
        <div className="text-center mb-16">
          <h2 className="text-3xl font-bold text-gray-900 mb-4">
            Why Choose Bondr?
          </h2>
          <p className="text-lg text-gray-600 max-w-2xl mx-auto">
            Revolutionary features that make contract management simple, secure, and transparent.
          </p>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {features.map((feature, index) => (
            <Card key={index} className="text-center border-0 shadow-lg">
              <CardHeader>
                <div className="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mx-auto mb-4">
                  <feature.icon className="h-6 w-6 text-primary" />
                </div>
                <CardTitle className="text-xl">{feature.title}</CardTitle>
              </CardHeader>
              <CardContent>
                <CardDescription className="text-base">
                  {feature.description}
                </CardDescription>
              </CardContent>
            </Card>
          ))}
        </div>
      </section>

      {/* CTA Section */}
      <section className="container mx-auto px-6 py-20">
        <Card className="bg-primary text-primary-foreground border-0">
          <CardContent className="p-12 text-center">
            <h3 className="text-3xl font-bold mb-4">
              Ready to Create Your First Agreement?
            </h3>
            <p className="text-lg mb-8 opacity-90">
              Join thousands of creators and businesses using Bondr for secure, milestone-based contracts.
            </p>
            <Button size="lg" variant="secondary" asChild>
              <Link to="/dashboard" className="flex items-center gap-2">
                Start Building <ArrowRight className="h-4 w-4" />
              </Link>
            </Button>
          </CardContent>
        </Card>
      </section>

      {/* Footer */}
      <footer className="container mx-auto px-6 py-8 border-t">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <div className="w-6 h-6 bg-primary rounded flex items-center justify-center">
              <span className="text-white font-bold text-sm">B</span>
            </div>
            <span className="font-bold text-primary">Bondr</span>
          </div>
          <p className="text-gray-600 text-sm">
            © 2024 Bondr. All rights reserved.
          </p>
        </div>
      </footer>
    </div>
  );
};

export default Index;
