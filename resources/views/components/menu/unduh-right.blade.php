<div class="download-wrap">
<a href="# {{-- {{ $filePath }} --}}" download class="df-btn df-download">
  <span class="df-ic" aria-hidden="true">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
      <path d="M4 4h16v12H4V4z" stroke="##0ea5e9" stroke-width="2" stroke-linecap="round"/>
    </svg>
  </span>
  Unduh{{-- {{ $buttonText }}- --}}
</a>
</div>

<style>

.download-wrap {
  display: flex;
  justify-content: flex-end; 
  margin-right:60px;
  margin-top:-32px;
}

.df-btn.df-download {
  appearance: none;
  border: 1px solid #d1d5db;        
  background: #ffffff;              
  color: #111827;                    
  padding: 5px 6px;                  
  border-radius: 8px;                
  cursor: pointer;                 
  font-size: 12px;                  
  display: inline-flex;              
  align-items: center;                
  gap: 6px;                           
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647); 
  line-height: 1;        
  text-decoration: none   
}

.df-btn.df-download:hover {
  background: #f8fafc;               
}

.df-btn.df-download .df-ic svg {
  display: block;
  width: 14px;                        
  height: 14px;
  vertical-align: middle;            
}

</style>