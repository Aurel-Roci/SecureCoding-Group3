/*     */ import java.awt.event.KeyAdapter;
/*     */ import java.awt.event.KeyEvent;
/*     */ import javax.swing.JLabel;
/*     */ import javax.swing.JTextField;
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ class MainFrame$2
/*     */   extends KeyAdapter
/*     */ {
/*     */   MainFrame$2(MainFrame paramMainFrame) {}
/*     */   
/*     */   public void keyPressed(KeyEvent e)
/*     */   {
/* 108 */     if (((e.getKeyChar() >= '0') && (e.getKeyChar() <= '9')) || (e.getKeyCode() == 127) || (e.getKeyCode() == 8)) {
/* 109 */       MainFrame.access$1(this.this$0).setEditable(true);
/* 110 */       MainFrame.access$2(this.this$0).setText("");
/*     */     } else {
/* 112 */       MainFrame.access$1(this.this$0).setEditable(false);
/* 113 */       MainFrame.access$2(this.this$0).setText("* Enter only numeric digits(0-9)");
/*     */     }
/*     */   }
/*     */ }


/* Location:              /Users/stefankofler/Documents/phase4/SourceAndBinary-Team2-Phase3.zip/scs.jar!/MainFrame$2.class
 * Java compiler version: 7 (51.0)
 * JD-Core Version:       0.7.1
 */