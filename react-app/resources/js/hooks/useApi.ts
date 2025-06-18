import { useState, useEffect } from 'react';
import { useToast } from '@/hooks/use-toast';

interface UseApiOptions {
  onSuccess?: (data: any) => void;
  onError?: (error: any) => void;
  showSuccessToast?: boolean;
  showErrorToast?: boolean;
}

export function useApi<T>(
  apiFunction: () => Promise<T>,
  dependencies: any[] = [],
  options: UseApiOptions = {}
) {
  const [data, setData] = useState<T | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const { toast } = useToast();

  const { onSuccess, onError, showSuccessToast = false, showErrorToast = true } = options;

  const fetchData = async () => {
    try {
      setLoading(true);
      setError(null);
      const result = await apiFunction();
      setData(result);
      
      if (onSuccess) {
        onSuccess(result);
      }
      
      if (showSuccessToast) {
        toast({
          title: "Success",
          description: "Data loaded successfully",
        });
      }
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || err.message || 'An error occurred';
      setError(errorMessage);
      
      if (onError) {
        onError(err);
      }
      
      if (showErrorToast) {
        toast({
          title: "Error",
          description: errorMessage,
          variant: "destructive",
        });
      }
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, dependencies);

  const refetch = async () => {
    await fetchData();
  };

  return { data, loading, error, refetch };
}

export function useApiMutation<T, P>(
  apiFunction: (params: P) => Promise<T>,
  options: UseApiOptions = {}
) {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const { toast } = useToast();

  const { onSuccess, onError, showSuccessToast = true, showErrorToast = true } = options;

  const mutate = async (params: P): Promise<T | null> => {
    try {
      setLoading(true);
      setError(null);
      const result = await apiFunction(params);
      
      if (onSuccess) {
        onSuccess(result);
      }
      
      if (showSuccessToast) {
        toast({
          title: "Success",
          description: "Operation completed successfully",
        });
      }
      
      return result;
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || err.message || 'An error occurred';
      setError(errorMessage);
      
      if (onError) {
        onError(err);
      }
      
      if (showErrorToast) {
        toast({
          title: "Error",
          description: errorMessage,
          variant: "destructive",
        });
      }
      
      return null;
    } finally {
      setLoading(false);
    }
  };

  return { mutate, loading, error };
}
