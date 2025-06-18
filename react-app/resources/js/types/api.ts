
// User types
export interface User {
  id: string;
  email: string;
  name: string;
  avatar?: string;
  created_at: string;
  updated_at: string;
}

// Agreement types
export interface Agreement {
  id: string;
  title: string;
  description: string;
  status: 'draft' | 'active' | 'completed' | 'cancelled';
  client_name: string;
  client_email: string;
  total_value: number;
  currency: string;
  start_date: string;
  end_date: string;
  created_at: string;
  updated_at: string;
  milestones: Milestone[];
}

// Milestone types
export interface Milestone {
  id: string;
  agreement_id: string;
  title: string;
  description: string;
  amount: number;
  due_date: string;
  status: 'pending' | 'in_progress' | 'completed' | 'overdue';
  completed_at?: string;
  created_at: string;
  updated_at: string;
}

// API Response types
export interface ApiResponse<T> {
  data: T;
  message?: string;
  status: 'success' | 'error';
}

export interface PaginatedResponse<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
  links: {
    first: string;
    last: string;
    prev?: string;
    next?: string;
  };
}

// Request types
export interface CreateAgreementRequest {
  title: string;
  description: string;
  client_name: string;
  client_email: string;
  total_value: number;
  currency: string;
  start_date: string;
  end_date: string;
}

export interface UpdateAgreementRequest extends Partial<CreateAgreementRequest> {
  status?: Agreement['status'];
}

export interface CreateMilestoneRequest {
  agreement_id: string;
  title: string;
  description: string;
  amount: number;
  due_date: string;
}

export interface UpdateMilestoneRequest extends Partial<CreateMilestoneRequest> {
  status?: Milestone['status'];
}
