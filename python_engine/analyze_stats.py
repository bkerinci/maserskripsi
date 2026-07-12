import sys
import pandas as pd
import json

def analyze(csv_path):
    try:
        # Try reading the CSV
        df = pd.read_csv(csv_path)
        
        # Basic descriptive statistics
        desc = df.describe().to_dict()
        
        # Simple Reliability Test (Cronbach's Alpha) on all numeric columns
        numeric_df = df.select_dtypes(include=['number', 'float', 'int'])
        
        alpha = None
        if numeric_df.shape[1] > 1:
            k = numeric_df.shape[1]
            variances = numeric_df.var(ddof=1)
            total_variance = numeric_df.sum(axis=1).var(ddof=1)
            if total_variance > 0:
                alpha = (k / (k - 1)) * (1 - (variances.sum() / total_variance))
        
        # Null values count
        null_counts = df.isnull().sum().to_dict()
        
        result = {
            'success': True,
            'rows': df.shape[0],
            'cols': df.shape[1],
            'columns': list(df.columns),
            'descriptive_stats': desc,
            'missing_values': null_counts,
            'cronbach_alpha': alpha
        }
        print(json.dumps(result))
    except Exception as e:
        print(json.dumps({'success': False, 'message': str(e)}))

if __name__ == '__main__':
    if len(sys.argv) > 1:
        analyze(sys.argv[1])
    else:
        print(json.dumps({'success': False, 'message': 'No CSV path provided'}))
