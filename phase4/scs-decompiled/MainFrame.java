/*     */ import java.awt.Container;
/*     */ import java.awt.EventQueue;
/*     */ import java.awt.GridBagConstraints;
/*     */ import java.awt.GridBagLayout;
/*     */ import java.awt.Insets;
/*     */ import java.awt.event.ActionEvent;
/*     */ import java.awt.event.ActionListener;
/*     */ import java.awt.event.ItemEvent;
/*     */ import java.awt.event.ItemListener;
/*     */ import java.awt.event.KeyAdapter;
/*     */ import java.awt.event.KeyEvent;
/*     */ import java.io.File;
/*     */ import java.io.PrintStream;
/*     */ import java.security.MessageDigest;
/*     */ import java.security.SecureRandom;
/*     */ import java.util.Random;
/*     */ import javax.crypto.Cipher;
/*     */ import javax.crypto.spec.IvParameterSpec;
/*     */ import javax.crypto.spec.SecretKeySpec;
/*     */ import javax.swing.JButton;
/*     */ import javax.swing.JCheckBox;
/*     */ import javax.swing.JFileChooser;
/*     */ import javax.swing.JFrame;
/*     */ import javax.swing.JLabel;
/*     */ import javax.swing.JTextField;
/*     */ import javax.swing.JTextPane;
/*     */ import javax.xml.bind.DatatypeConverter;
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
/*     */ public class MainFrame
/*     */ {
/*     */   private JFrame frame;
/*  44 */   private final JButton buttonGenerate = new JButton("Generate TAN");
/*     */   
/*     */   private JTextField textFieldPIN;
/*     */   
/*     */   private JTextField textFieldMoney;
/*     */   private JTextField textFieldTargetAccount;
/*     */   private JTextField textFieldTANPath;
/*     */   private JLabel lblPin;
/*     */   private JLabel lblAmountOfMoney;
/*     */   private JLabel lblTargetAccount;
/*     */   private JLabel lblFilePathFor;
/*     */   private JLabel lblHelloDearCostumer;
/*     */   private JLabel lblStatus;
/*     */   private JButton btnNewButton;
/*     */   private JTextPane textPaneTAN;
/*     */   private JLabel lblGeneratedTan;
/*     */   private JCheckBox chckbxUseTransactionFile;
/*  61 */   static String IV = "AAAAAAAAAAAAAAAA";
/*  62 */   static Random randomGenerator = new Random();
/*     */   
/*     */ 
/*     */ 
/*     */   public static void main(String[] args)
/*     */   {
/*  68 */     EventQueue.invokeLater(new Runnable() {
/*     */       public void run() {
/*     */         try {
/*  71 */           MainFrame window = new MainFrame();
/*  72 */           window.frame.setVisible(true);
/*     */         } catch (Exception e) {
/*  74 */           e.printStackTrace();
/*     */         }
/*     */       }
/*     */     });
/*     */   }
/*     */   
/*     */ 
/*     */ 
/*     */   public MainFrame()
/*     */   {
/*  84 */     initialize();
/*     */   }
/*     */   
/*     */ 
/*     */ 
/*     */   private void initialize()
/*     */   {
/*  91 */     this.frame = new JFrame();
/*  92 */     this.frame.setBounds(100, 100, 590, 319);
/*  93 */     this.frame.setDefaultCloseOperation(3);
/*  94 */     GridBagLayout gridBagLayout = new GridBagLayout();
/*  95 */     gridBagLayout.columnWidths = new int[] { 239, 114, 51, 15 };
/*  96 */     gridBagLayout.rowHeights = new int[] { 59, 19, 19, 0, 19, 19 };
/*  97 */     gridBagLayout.columnWeights = new double[] { 1.0D, 0.0D, 0.0D, Double.MIN_VALUE };
/*  98 */     gridBagLayout.rowWeights = new double[] { 0.0D, 0.0D, 0.0D, 0.0D, 0.0D, 0.0D, 0.0D, 0.0D, 0.0D, Double.MIN_VALUE };
/*  99 */     this.frame.getContentPane().setLayout(gridBagLayout);
/*     */     
/* 101 */     this.textFieldPIN = new JTextField();
/* 102 */     this.textFieldPIN.setHorizontalAlignment(2);
/* 103 */     this.textFieldPIN.addKeyListener(new KeyAdapter()
/*     */     {
/*     */ 
/*     */       public void keyPressed(KeyEvent e)
/*     */       {
/* 108 */         if (((e.getKeyChar() >= '0') && (e.getKeyChar() <= '9')) || (e.getKeyCode() == 127) || (e.getKeyCode() == 8)) {
/* 109 */           MainFrame.this.textFieldPIN.setEditable(true);
/* 110 */           MainFrame.this.lblStatus.setText("");
/*     */         } else {
/* 112 */           MainFrame.this.textFieldPIN.setEditable(false);
/* 113 */           MainFrame.this.lblStatus.setText("* Enter only numeric digits(0-9)");
/*     */         }
/*     */         
/*     */       }
/* 117 */     });
/* 118 */     this.lblHelloDearCostumer = new JLabel("Hello Dear Costumer to TU Bank!");
/* 119 */     GridBagConstraints gbc_lblHelloDearCostumer = new GridBagConstraints();
/* 120 */     gbc_lblHelloDearCostumer.gridwidth = 4;
/* 121 */     gbc_lblHelloDearCostumer.insets = new Insets(0, 0, 5, 0);
/* 122 */     gbc_lblHelloDearCostumer.gridx = 0;
/* 123 */     gbc_lblHelloDearCostumer.gridy = 0;
/* 124 */     this.frame.getContentPane().add(this.lblHelloDearCostumer, gbc_lblHelloDearCostumer);
/*     */     
/* 126 */     this.lblPin = new JLabel("PIN:");
/* 127 */     GridBagConstraints gbc_lblPin = new GridBagConstraints();
/* 128 */     gbc_lblPin.insets = new Insets(0, 0, 5, 5);
/* 129 */     gbc_lblPin.anchor = 13;
/* 130 */     gbc_lblPin.gridx = 0;
/* 131 */     gbc_lblPin.gridy = 1;
/* 132 */     this.frame.getContentPane().add(this.lblPin, gbc_lblPin);
/* 133 */     this.textFieldPIN.setToolTipText("Insert PIN");
/* 134 */     GridBagConstraints gbc_textFieldPIN = new GridBagConstraints();
/* 135 */     gbc_textFieldPIN.anchor = 11;
/* 136 */     gbc_textFieldPIN.fill = 2;
/* 137 */     gbc_textFieldPIN.insets = new Insets(0, 0, 5, 5);
/* 138 */     gbc_textFieldPIN.gridx = 1;
/* 139 */     gbc_textFieldPIN.gridy = 1;
/* 140 */     this.frame.getContentPane().add(this.textFieldPIN, gbc_textFieldPIN);
/* 141 */     this.textFieldPIN.setColumns(10);
/*     */     
/* 143 */     this.lblAmountOfMoney = new JLabel("Amount of Money:");
/* 144 */     GridBagConstraints gbc_lblAmountOfMoney = new GridBagConstraints();
/* 145 */     gbc_lblAmountOfMoney.insets = new Insets(0, 0, 5, 5);
/* 146 */     gbc_lblAmountOfMoney.anchor = 13;
/* 147 */     gbc_lblAmountOfMoney.gridx = 0;
/* 148 */     gbc_lblAmountOfMoney.gridy = 2;
/* 149 */     this.frame.getContentPane().add(this.lblAmountOfMoney, gbc_lblAmountOfMoney);
/*     */     
/* 151 */     this.textFieldMoney = new JTextField();
/* 152 */     this.textFieldMoney.addKeyListener(new KeyAdapter()
/*     */     {
/*     */ 
/*     */       public void keyPressed(KeyEvent e)
/*     */       {
/* 157 */         if (((e.getKeyChar() >= '0') && (e.getKeyChar() <= '9')) || (e.getKeyCode() == 127) || (e.getKeyCode() == 8)) {
/* 158 */           MainFrame.this.textFieldMoney.setEditable(true);
/* 159 */           MainFrame.this.lblStatus.setText("");
/*     */         } else {
/* 161 */           MainFrame.this.textFieldMoney.setEditable(false);
/* 162 */           MainFrame.this.lblStatus.setText("* Enter only numeric digits(0-9)");
/*     */         }
/*     */       }
/* 165 */     });
/* 166 */     GridBagConstraints gbc_textFieldMoney = new GridBagConstraints();
/* 167 */     gbc_textFieldMoney.anchor = 11;
/* 168 */     gbc_textFieldMoney.fill = 2;
/* 169 */     gbc_textFieldMoney.insets = new Insets(0, 0, 5, 5);
/* 170 */     gbc_textFieldMoney.gridx = 1;
/* 171 */     gbc_textFieldMoney.gridy = 2;
/* 172 */     this.frame.getContentPane().add(this.textFieldMoney, gbc_textFieldMoney);
/* 173 */     this.textFieldMoney.setColumns(10);
/*     */     
/* 175 */     this.lblTargetAccount = new JLabel("Target Account:");
/* 176 */     GridBagConstraints gbc_lblTargetAccount = new GridBagConstraints();
/* 177 */     gbc_lblTargetAccount.insets = new Insets(0, 0, 5, 5);
/* 178 */     gbc_lblTargetAccount.anchor = 13;
/* 179 */     gbc_lblTargetAccount.gridx = 0;
/* 180 */     gbc_lblTargetAccount.gridy = 3;
/* 181 */     this.frame.getContentPane().add(this.lblTargetAccount, gbc_lblTargetAccount);
/*     */     
/* 183 */     this.textFieldTargetAccount = new JTextField();
/* 184 */     this.textFieldTargetAccount.addKeyListener(new KeyAdapter()
/*     */     {
/*     */ 
/*     */       public void keyPressed(KeyEvent e)
/*     */       {
/* 189 */         if (((e.getKeyChar() >= '0') && (e.getKeyChar() <= '9')) || ((e.getKeyChar() >= 'A') && (e.getKeyChar() <= 'Z')) || ((e.getKeyChar() >= 'a') && (e.getKeyChar() <= 'z')) || (e.getKeyCode() == 127) || (e.getKeyCode() == 8)) {
/* 190 */           MainFrame.this.textFieldTargetAccount.setEditable(true);
/* 191 */           MainFrame.this.lblStatus.setText("");
/*     */         } else {
/* 193 */           MainFrame.this.textFieldTargetAccount.setEditable(false);
/* 194 */           MainFrame.this.lblStatus.setText("* Enter only numeric digits(0-9), or uppercase");
/*     */         }
/*     */       }
/* 197 */     });
/* 198 */     GridBagConstraints gbc_textFieldTargetAccount = new GridBagConstraints();
/* 199 */     gbc_textFieldTargetAccount.anchor = 11;
/* 200 */     gbc_textFieldTargetAccount.fill = 2;
/* 201 */     gbc_textFieldTargetAccount.insets = new Insets(0, 0, 5, 5);
/* 202 */     gbc_textFieldTargetAccount.gridx = 1;
/* 203 */     gbc_textFieldTargetAccount.gridy = 3;
/* 204 */     this.frame.getContentPane().add(this.textFieldTargetAccount, gbc_textFieldTargetAccount);
/* 205 */     this.textFieldTargetAccount.setColumns(10);
/*     */     
/* 207 */     this.lblFilePathFor = new JLabel("File path for generating a TAN:");
/* 208 */     GridBagConstraints gbc_lblFilePathFor = new GridBagConstraints();
/* 209 */     gbc_lblFilePathFor.insets = new Insets(0, 0, 5, 5);
/* 210 */     gbc_lblFilePathFor.anchor = 13;
/* 211 */     gbc_lblFilePathFor.gridx = 0;
/* 212 */     gbc_lblFilePathFor.gridy = 4;
/* 213 */     this.frame.getContentPane().add(this.lblFilePathFor, gbc_lblFilePathFor);
/*     */     
/* 215 */     this.textFieldTANPath = new JTextField();
/* 216 */     this.textFieldTANPath.setEditable(false);
/* 217 */     GridBagConstraints gbc_textFieldTANPath = new GridBagConstraints();
/* 218 */     gbc_textFieldTANPath.anchor = 11;
/* 219 */     gbc_textFieldTANPath.fill = 2;
/* 220 */     gbc_textFieldTANPath.insets = new Insets(0, 0, 5, 5);
/* 221 */     gbc_textFieldTANPath.gridx = 1;
/* 222 */     gbc_textFieldTANPath.gridy = 4;
/* 223 */     this.frame.getContentPane().add(this.textFieldTANPath, gbc_textFieldTANPath);
/* 224 */     this.textFieldTANPath.setColumns(10);
/*     */     
/* 226 */     this.btnNewButton = new JButton("Browse...");
/* 227 */     this.btnNewButton.addActionListener(new ActionListener()
/*     */     {
/*     */       public void actionPerformed(ActionEvent arg0) {
/* 230 */         JFileChooser fileChooser = new JFileChooser();
/* 231 */         fileChooser.setCurrentDirectory(new File(System.getProperty("user.home")));
/* 232 */         int result = fileChooser.showOpenDialog(MainFrame.this.btnNewButton);
/* 233 */         if (result == 0) {
/* 234 */           File selectedFile = fileChooser.getSelectedFile();
/* 235 */           MainFrame.this.textFieldTANPath.setText(selectedFile.getAbsolutePath());
/* 236 */           MainFrame.this.chckbxUseTransactionFile.setSelected(true);
/*     */         }
/*     */       }
/* 239 */     });
/* 240 */     GridBagConstraints gbc_btnNewButton = new GridBagConstraints();
/* 241 */     gbc_btnNewButton.insets = new Insets(0, 0, 5, 5);
/* 242 */     gbc_btnNewButton.gridx = 2;
/* 243 */     gbc_btnNewButton.gridy = 4;
/* 244 */     this.frame.getContentPane().add(this.btnNewButton, gbc_btnNewButton);
/* 245 */     GridBagConstraints gbc_buttonGenerate = new GridBagConstraints();
/* 246 */     gbc_buttonGenerate.insets = new Insets(0, 0, 5, 5);
/* 247 */     gbc_buttonGenerate.gridx = 1;
/* 248 */     gbc_buttonGenerate.gridy = 5;
/* 249 */     this.buttonGenerate.addActionListener(new ActionListener()
/*     */     {
/*     */       /* Error */
/*     */       public void actionPerformed(ActionEvent arg0)
/*     */       {
/*     */         // Byte code:
/*     */         //   0: aload_0
/*     */         //   1: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   4: invokestatic 23	MainFrame:access$1	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   7: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   10: ldc 35
/*     */         //   12: invokevirtual 37	java/lang/String:equals	(Ljava/lang/Object;)Z
/*     */         //   15: ifeq +16 -> 31
/*     */         //   18: aload_0
/*     */         //   19: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   22: invokestatic 43	MainFrame:access$2	(LMainFrame;)Ljavax/swing/JLabel;
/*     */         //   25: ldc 47
/*     */         //   27: invokevirtual 49	javax/swing/JLabel:setText	(Ljava/lang/String;)V
/*     */         //   30: return
/*     */         //   31: aload_0
/*     */         //   32: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   35: invokestatic 55	MainFrame:access$8	(LMainFrame;)[B
/*     */         //   38: astore_2
/*     */         //   39: aload_2
/*     */         //   40: invokestatic 59	javax/xml/bind/DatatypeConverter:printBase64Binary	([B)Ljava/lang/String;
/*     */         //   43: ldc 65
/*     */         //   45: invokevirtual 67	java/lang/String:getBytes	(Ljava/lang/String;)[B
/*     */         //   48: astore_3
/*     */         //   49: ldc 35
/*     */         //   51: astore 4
/*     */         //   53: new 71	java/lang/StringBuilder
/*     */         //   56: dup
/*     */         //   57: aload_0
/*     */         //   58: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   61: invokevirtual 73	MainFrame:generateRandomNumber	()I
/*     */         //   64: invokestatic 77	java/lang/Integer:toString	(I)Ljava/lang/String;
/*     */         //   67: invokestatic 83	java/lang/String:valueOf	(Ljava/lang/Object;)Ljava/lang/String;
/*     */         //   70: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   73: ldc 89
/*     */         //   75: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   78: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   81: astore 5
/*     */         //   83: aload_0
/*     */         //   84: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   87: invokestatic 23	MainFrame:access$1	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   90: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   93: astore 8
/*     */         //   95: aload_0
/*     */         //   96: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   99: invokestatic 97	MainFrame:access$7	(LMainFrame;)Ljavax/swing/JCheckBox;
/*     */         //   102: invokevirtual 101	javax/swing/JCheckBox:isSelected	()Z
/*     */         //   105: ifeq +301 -> 406
/*     */         //   108: aload_0
/*     */         //   109: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   112: invokestatic 107	MainFrame:access$6	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   115: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   118: ldc 35
/*     */         //   120: invokevirtual 37	java/lang/String:equals	(Ljava/lang/Object;)Z
/*     */         //   123: ifeq +16 -> 139
/*     */         //   126: aload_0
/*     */         //   127: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   130: invokestatic 43	MainFrame:access$2	(LMainFrame;)Ljavax/swing/JLabel;
/*     */         //   133: ldc 110
/*     */         //   135: invokevirtual 49	javax/swing/JLabel:setText	(Ljava/lang/String;)V
/*     */         //   138: return
/*     */         //   139: aload_0
/*     */         //   140: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   143: invokestatic 107	MainFrame:access$6	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   146: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   149: astore 9
/*     */         //   151: aconst_null
/*     */         //   152: astore 10
/*     */         //   154: ldc 35
/*     */         //   156: astore 11
/*     */         //   158: ldc 89
/*     */         //   160: astore 12
/*     */         //   162: new 112	java/io/BufferedReader
/*     */         //   165: dup
/*     */         //   166: new 114	java/io/FileReader
/*     */         //   169: dup
/*     */         //   170: aload 9
/*     */         //   172: invokespecial 116	java/io/FileReader:<init>	(Ljava/lang/String;)V
/*     */         //   175: invokespecial 117	java/io/BufferedReader:<init>	(Ljava/io/Reader;)V
/*     */         //   178: astore 10
/*     */         //   180: goto +64 -> 244
/*     */         //   183: aload 11
/*     */         //   185: aload 12
/*     */         //   187: invokevirtual 120	java/lang/String:split	(Ljava/lang/String;)[Ljava/lang/String;
/*     */         //   190: astore 13
/*     */         //   192: getstatic 124	java/lang/System:out	Ljava/io/PrintStream;
/*     */         //   195: aload 13
/*     */         //   197: invokestatic 130	java/util/Arrays:deepToString	([Ljava/lang/Object;)Ljava/lang/String;
/*     */         //   200: invokevirtual 136	java/io/PrintStream:println	(Ljava/lang/String;)V
/*     */         //   203: new 71	java/lang/StringBuilder
/*     */         //   206: dup
/*     */         //   207: aload 5
/*     */         //   209: invokestatic 83	java/lang/String:valueOf	(Ljava/lang/Object;)Ljava/lang/String;
/*     */         //   212: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   215: aload 13
/*     */         //   217: iconst_1
/*     */         //   218: aaload
/*     */         //   219: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   222: ldc 89
/*     */         //   224: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   227: aload 13
/*     */         //   229: iconst_3
/*     */         //   230: aaload
/*     */         //   231: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   234: ldc 89
/*     */         //   236: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   239: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   242: astore 5
/*     */         //   244: aload 10
/*     */         //   246: invokevirtual 141	java/io/BufferedReader:readLine	()Ljava/lang/String;
/*     */         //   249: dup
/*     */         //   250: astore 11
/*     */         //   252: ifnonnull -69 -> 183
/*     */         //   255: aload 4
/*     */         //   257: invokevirtual 144	java/lang/String:length	()I
/*     */         //   260: ifle +123 -> 383
/*     */         //   263: aload 4
/*     */         //   265: aload 4
/*     */         //   267: invokevirtual 144	java/lang/String:length	()I
/*     */         //   270: iconst_1
/*     */         //   271: isub
/*     */         //   272: invokevirtual 147	java/lang/String:charAt	(I)C
/*     */         //   275: bipush 44
/*     */         //   277: if_icmpne +106 -> 383
/*     */         //   280: aload 4
/*     */         //   282: iconst_0
/*     */         //   283: aload 4
/*     */         //   285: invokevirtual 144	java/lang/String:length	()I
/*     */         //   288: iconst_1
/*     */         //   289: isub
/*     */         //   290: invokevirtual 151	java/lang/String:substring	(II)Ljava/lang/String;
/*     */         //   293: astore 5
/*     */         //   295: goto +88 -> 383
/*     */         //   298: astore 13
/*     */         //   300: aload 13
/*     */         //   302: invokevirtual 155	java/io/FileNotFoundException:printStackTrace	()V
/*     */         //   305: aload 10
/*     */         //   307: ifnull +196 -> 503
/*     */         //   310: aload 10
/*     */         //   312: invokevirtual 160	java/io/BufferedReader:close	()V
/*     */         //   315: goto +188 -> 503
/*     */         //   318: astore 15
/*     */         //   320: aload 15
/*     */         //   322: invokevirtual 163	java/io/IOException:printStackTrace	()V
/*     */         //   325: goto +178 -> 503
/*     */         //   328: astore 13
/*     */         //   330: aload 13
/*     */         //   332: invokevirtual 163	java/io/IOException:printStackTrace	()V
/*     */         //   335: aload 10
/*     */         //   337: ifnull +166 -> 503
/*     */         //   340: aload 10
/*     */         //   342: invokevirtual 160	java/io/BufferedReader:close	()V
/*     */         //   345: goto +158 -> 503
/*     */         //   348: astore 15
/*     */         //   350: aload 15
/*     */         //   352: invokevirtual 163	java/io/IOException:printStackTrace	()V
/*     */         //   355: goto +148 -> 503
/*     */         //   358: astore 14
/*     */         //   360: aload 10
/*     */         //   362: ifnull +18 -> 380
/*     */         //   365: aload 10
/*     */         //   367: invokevirtual 160	java/io/BufferedReader:close	()V
/*     */         //   370: goto +10 -> 380
/*     */         //   373: astore 15
/*     */         //   375: aload 15
/*     */         //   377: invokevirtual 163	java/io/IOException:printStackTrace	()V
/*     */         //   380: aload 14
/*     */         //   382: athrow
/*     */         //   383: aload 10
/*     */         //   385: ifnull +118 -> 503
/*     */         //   388: aload 10
/*     */         //   390: invokevirtual 160	java/io/BufferedReader:close	()V
/*     */         //   393: goto +110 -> 503
/*     */         //   396: astore 15
/*     */         //   398: aload 15
/*     */         //   400: invokevirtual 163	java/io/IOException:printStackTrace	()V
/*     */         //   403: goto +100 -> 503
/*     */         //   406: aload_0
/*     */         //   407: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   410: invokestatic 166	MainFrame:access$4	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   413: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   416: ldc 35
/*     */         //   418: invokevirtual 37	java/lang/String:equals	(Ljava/lang/Object;)Z
/*     */         //   421: ifne +21 -> 442
/*     */         //   424: aload_0
/*     */         //   425: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   428: invokestatic 169	MainFrame:access$3	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   431: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   434: ldc 35
/*     */         //   436: invokevirtual 37	java/lang/String:equals	(Ljava/lang/Object;)Z
/*     */         //   439: ifeq +16 -> 455
/*     */         //   442: aload_0
/*     */         //   443: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   446: invokestatic 43	MainFrame:access$2	(LMainFrame;)Ljavax/swing/JLabel;
/*     */         //   449: ldc -84
/*     */         //   451: invokevirtual 49	javax/swing/JLabel:setText	(Ljava/lang/String;)V
/*     */         //   454: return
/*     */         //   455: new 71	java/lang/StringBuilder
/*     */         //   458: dup
/*     */         //   459: aload 5
/*     */         //   461: invokestatic 83	java/lang/String:valueOf	(Ljava/lang/Object;)Ljava/lang/String;
/*     */         //   464: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   467: aload_0
/*     */         //   468: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   471: invokestatic 166	MainFrame:access$4	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   474: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   477: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   480: ldc 89
/*     */         //   482: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   485: aload_0
/*     */         //   486: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   489: invokestatic 169	MainFrame:access$3	(LMainFrame;)Ljavax/swing/JTextField;
/*     */         //   492: invokevirtual 29	javax/swing/JTextField:getText	()Ljava/lang/String;
/*     */         //   495: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   498: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   501: astore 5
/*     */         //   503: new 71	java/lang/StringBuilder
/*     */         //   506: dup
/*     */         //   507: aload 5
/*     */         //   509: invokestatic 83	java/lang/String:valueOf	(Ljava/lang/Object;)Ljava/lang/String;
/*     */         //   512: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   515: aload 8
/*     */         //   517: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   520: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   523: ldc 65
/*     */         //   525: invokevirtual 67	java/lang/String:getBytes	(Ljava/lang/String;)[B
/*     */         //   528: astore 9
/*     */         //   530: new 71	java/lang/StringBuilder
/*     */         //   533: dup
/*     */         //   534: aload 5
/*     */         //   536: invokestatic 83	java/lang/String:valueOf	(Ljava/lang/Object;)Ljava/lang/String;
/*     */         //   539: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   542: ldc -82
/*     */         //   544: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   547: new 38	java/lang/String
/*     */         //   550: dup
/*     */         //   551: aload 9
/*     */         //   553: invokestatic 176	MainFrame:getsha256	([B)[B
/*     */         //   556: invokestatic 59	javax/xml/bind/DatatypeConverter:printBase64Binary	([B)Ljava/lang/String;
/*     */         //   559: invokespecial 180	java/lang/String:<init>	(Ljava/lang/String;)V
/*     */         //   562: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   565: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   568: astore 4
/*     */         //   570: aload_0
/*     */         //   571: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   574: invokestatic 181	MainFrame:access$9	(LMainFrame;)Ljavax/swing/JTextPane;
/*     */         //   577: aload 4
/*     */         //   579: invokevirtual 185	javax/swing/JTextPane:setText	(Ljava/lang/String;)V
/*     */         //   582: getstatic 124	java/lang/System:out	Ljava/io/PrintStream;
/*     */         //   585: new 71	java/lang/StringBuilder
/*     */         //   588: dup
/*     */         //   589: ldc -68
/*     */         //   591: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   594: aload 4
/*     */         //   596: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   599: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   602: invokevirtual 136	java/io/PrintStream:println	(Ljava/lang/String;)V
/*     */         //   605: getstatic 124	java/lang/System:out	Ljava/io/PrintStream;
/*     */         //   608: new 71	java/lang/StringBuilder
/*     */         //   611: dup
/*     */         //   612: ldc -66
/*     */         //   614: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   617: new 38	java/lang/String
/*     */         //   620: dup
/*     */         //   621: aload 8
/*     */         //   623: invokespecial 180	java/lang/String:<init>	(Ljava/lang/String;)V
/*     */         //   626: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   629: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   632: invokevirtual 136	java/io/PrintStream:println	(Ljava/lang/String;)V
/*     */         //   635: getstatic 124	java/lang/System:out	Ljava/io/PrintStream;
/*     */         //   638: new 71	java/lang/StringBuilder
/*     */         //   641: dup
/*     */         //   642: ldc -64
/*     */         //   644: invokespecial 87	java/lang/StringBuilder:<init>	(Ljava/lang/String;)V
/*     */         //   647: new 38	java/lang/String
/*     */         //   650: dup
/*     */         //   651: aload 9
/*     */         //   653: invokespecial 194	java/lang/String:<init>	([B)V
/*     */         //   656: invokevirtual 91	java/lang/StringBuilder:append	(Ljava/lang/String;)Ljava/lang/StringBuilder;
/*     */         //   659: invokevirtual 95	java/lang/StringBuilder:toString	()Ljava/lang/String;
/*     */         //   662: invokevirtual 136	java/io/PrintStream:println	(Ljava/lang/String;)V
/*     */         //   665: goto +26 -> 691
/*     */         //   668: astore_2
/*     */         //   669: getstatic 124	java/lang/System:out	Ljava/io/PrintStream;
/*     */         //   672: aload_2
/*     */         //   673: invokevirtual 197	java/lang/Exception:getMessage	()Ljava/lang/String;
/*     */         //   676: invokevirtual 136	java/io/PrintStream:println	(Ljava/lang/String;)V
/*     */         //   679: aload_0
/*     */         //   680: getfield 12	MainFrame$6:this$0	LMainFrame;
/*     */         //   683: invokestatic 181	MainFrame:access$9	(LMainFrame;)Ljavax/swing/JTextPane;
/*     */         //   686: ldc -54
/*     */         //   688: invokevirtual 185	javax/swing/JTextPane:setText	(Ljava/lang/String;)V
/*     */         //   691: return
/*     */         // Line number table:
/*     */         //   Java source line #251	-> byte code offset #0
/*     */         //   Java source line #252	-> byte code offset #18
/*     */         //   Java source line #253	-> byte code offset #30
/*     */         //   Java source line #256	-> byte code offset #31
/*     */         //   Java source line #258	-> byte code offset #39
/*     */         //   Java source line #260	-> byte code offset #49
/*     */         //   Java source line #261	-> byte code offset #53
/*     */         //   Java source line #264	-> byte code offset #83
/*     */         //   Java source line #266	-> byte code offset #95
/*     */         //   Java source line #267	-> byte code offset #108
/*     */         //   Java source line #268	-> byte code offset #126
/*     */         //   Java source line #269	-> byte code offset #138
/*     */         //   Java source line #273	-> byte code offset #139
/*     */         //   Java source line #274	-> byte code offset #151
/*     */         //   Java source line #275	-> byte code offset #154
/*     */         //   Java source line #276	-> byte code offset #158
/*     */         //   Java source line #279	-> byte code offset #162
/*     */         //   Java source line #280	-> byte code offset #180
/*     */         //   Java source line #282	-> byte code offset #183
/*     */         //   Java source line #283	-> byte code offset #192
/*     */         //   Java source line #286	-> byte code offset #203
/*     */         //   Java source line #280	-> byte code offset #244
/*     */         //   Java source line #288	-> byte code offset #255
/*     */         //   Java source line #289	-> byte code offset #280
/*     */         //   Java source line #291	-> byte code offset #295
/*     */         //   Java source line #292	-> byte code offset #300
/*     */         //   Java source line #296	-> byte code offset #305
/*     */         //   Java source line #298	-> byte code offset #310
/*     */         //   Java source line #299	-> byte code offset #315
/*     */         //   Java source line #300	-> byte code offset #320
/*     */         //   Java source line #293	-> byte code offset #328
/*     */         //   Java source line #294	-> byte code offset #330
/*     */         //   Java source line #296	-> byte code offset #335
/*     */         //   Java source line #298	-> byte code offset #340
/*     */         //   Java source line #299	-> byte code offset #345
/*     */         //   Java source line #300	-> byte code offset #350
/*     */         //   Java source line #295	-> byte code offset #358
/*     */         //   Java source line #296	-> byte code offset #360
/*     */         //   Java source line #298	-> byte code offset #365
/*     */         //   Java source line #299	-> byte code offset #370
/*     */         //   Java source line #300	-> byte code offset #375
/*     */         //   Java source line #303	-> byte code offset #380
/*     */         //   Java source line #296	-> byte code offset #383
/*     */         //   Java source line #298	-> byte code offset #388
/*     */         //   Java source line #299	-> byte code offset #393
/*     */         //   Java source line #300	-> byte code offset #398
/*     */         //   Java source line #304	-> byte code offset #403
/*     */         //   Java source line #306	-> byte code offset #406
/*     */         //   Java source line #307	-> byte code offset #442
/*     */         //   Java source line #308	-> byte code offset #454
/*     */         //   Java source line #310	-> byte code offset #455
/*     */         //   Java source line #316	-> byte code offset #503
/*     */         //   Java source line #317	-> byte code offset #530
/*     */         //   Java source line #318	-> byte code offset #570
/*     */         //   Java source line #321	-> byte code offset #582
/*     */         //   Java source line #322	-> byte code offset #605
/*     */         //   Java source line #324	-> byte code offset #635
/*     */         //   Java source line #328	-> byte code offset #665
/*     */         //   Java source line #329	-> byte code offset #668
/*     */         //   Java source line #330	-> byte code offset #669
/*     */         //   Java source line #331	-> byte code offset #679
/*     */         //   Java source line #333	-> byte code offset #691
/*     */         // Local variable table:
/*     */         //   start	length	slot	name	signature
/*     */         //   0	692	0	this	6
/*     */         //   0	692	1	arg0	ActionEvent
/*     */         //   38	2	2	salt	byte[]
/*     */         //   668	5	2	e	Exception
/*     */         //   48	2	3	base64salt	byte[]
/*     */         //   51	544	4	TAN	String
/*     */         //   81	454	5	tmp	String
/*     */         //   93	529	8	password	String
/*     */         //   149	22	9	csvFile	String
/*     */         //   528	124	9	sha	byte[]
/*     */         //   152	237	10	br	java.io.BufferedReader
/*     */         //   156	95	11	line	String
/*     */         //   160	26	12	cvsSplitBy	String
/*     */         //   190	38	13	transaction	String[]
/*     */         //   298	3	13	e	java.io.FileNotFoundException
/*     */         //   328	3	13	e	java.io.IOException
/*     */         //   358	23	14	localObject	Object
/*     */         //   318	3	15	e	java.io.IOException
/*     */         //   348	3	15	e	java.io.IOException
/*     */         //   373	3	15	e	java.io.IOException
/*     */         //   396	3	15	e	java.io.IOException
/*     */         // Exception table:
/*     */         //   from	to	target	type
/*     */         //   162	295	298	java/io/FileNotFoundException
/*     */         //   310	315	318	java/io/IOException
/*     */         //   162	295	328	java/io/IOException
/*     */         //   340	345	348	java/io/IOException
/*     */         //   162	305	358	finally
/*     */         //   328	335	358	finally
/*     */         //   365	370	373	java/io/IOException
/*     */         //   388	393	396	java/io/IOException
/*     */         //   31	138	668	java/lang/Exception
/*     */         //   139	454	668	java/lang/Exception
/*     */         //   455	665	668	java/lang/Exception
/*     */       }
/* 334 */     });
/* 335 */     this.frame.getContentPane().add(this.buttonGenerate, gbc_buttonGenerate);
/*     */     
/* 337 */     this.chckbxUseTransactionFile = new JCheckBox("Use transaction file");
/* 338 */     this.chckbxUseTransactionFile.addItemListener(new ItemListener() {
/*     */       public void itemStateChanged(ItemEvent arg0) {
/* 340 */         if (arg0.getStateChange() == 1) {
/* 341 */           MainFrame.this.textFieldMoney.setEditable(false);
/* 342 */           MainFrame.this.textFieldTargetAccount.setEditable(false);
/* 343 */           MainFrame.this.textFieldTANPath.setEditable(true);
/*     */         } else {
/* 345 */           MainFrame.this.textFieldMoney.setEditable(true);
/* 346 */           MainFrame.this.textFieldTargetAccount.setEditable(true);
/* 347 */           MainFrame.this.textFieldTANPath.setEditable(false);
/*     */         }
/*     */       }
/* 350 */     });
/* 351 */     GridBagConstraints gbc_chckbxUseTransactionFile = new GridBagConstraints();
/* 352 */     gbc_chckbxUseTransactionFile.insets = new Insets(0, 0, 5, 5);
/* 353 */     gbc_chckbxUseTransactionFile.gridx = 1;
/* 354 */     gbc_chckbxUseTransactionFile.gridy = 6;
/* 355 */     this.frame.getContentPane().add(this.chckbxUseTransactionFile, gbc_chckbxUseTransactionFile);
/*     */     
/* 357 */     this.lblGeneratedTan = new JLabel("Generated TAN:");
/* 358 */     GridBagConstraints gbc_lblGeneratedTan = new GridBagConstraints();
/* 359 */     gbc_lblGeneratedTan.anchor = 13;
/* 360 */     gbc_lblGeneratedTan.insets = new Insets(0, 0, 5, 5);
/* 361 */     gbc_lblGeneratedTan.gridx = 0;
/* 362 */     gbc_lblGeneratedTan.gridy = 7;
/* 363 */     this.frame.getContentPane().add(this.lblGeneratedTan, gbc_lblGeneratedTan);
/*     */     
/* 365 */     this.textPaneTAN = new JTextPane();
/* 366 */     this.textPaneTAN.setEditable(false);
/* 367 */     GridBagConstraints gbc_textPaneTAN = new GridBagConstraints();
/* 368 */     gbc_textPaneTAN.gridwidth = 2;
/* 369 */     gbc_textPaneTAN.anchor = 11;
/* 370 */     gbc_textPaneTAN.insets = new Insets(0, 0, 5, 5);
/* 371 */     gbc_textPaneTAN.fill = 2;
/* 372 */     gbc_textPaneTAN.gridx = 1;
/* 373 */     gbc_textPaneTAN.gridy = 7;
/* 374 */     this.frame.getContentPane().add(this.textPaneTAN, gbc_textPaneTAN);
/*     */     
/* 376 */     this.lblStatus = new JLabel("Status");
/* 377 */     GridBagConstraints gbc_lblStatus = new GridBagConstraints();
/* 378 */     gbc_lblStatus.gridwidth = 4;
/* 379 */     gbc_lblStatus.gridx = 0;
/* 380 */     gbc_lblStatus.gridy = 8;
/* 381 */     this.frame.getContentPane().add(this.lblStatus, gbc_lblStatus);
/*     */   }
/*     */   
/* 384 */   private byte[] generateSalt() { SecureRandom random = new SecureRandom();
/* 385 */     byte[] bytes = new byte[16];
/* 386 */     random.nextBytes(bytes);
/*     */     
/* 388 */     return bytes;
/*     */   }
/*     */   
/*     */   private static byte[] encrypt(String plainText, byte[] encryptionKey, byte[] salt) throws Exception {
/* 392 */     MessageDigest md = MessageDigest.getInstance("SHA-256");
/* 393 */     md.update(encryptionKey);
/* 394 */     byte[] rawkey = md.digest();
/* 395 */     System.out.println("sha256 of encryption key: " + new String(DatatypeConverter.printBase64Binary(rawkey)));
/* 396 */     Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding", "SunJCE");
/* 397 */     SecretKeySpec key = new SecretKeySpec(rawkey, "AES");
/* 398 */     cipher.init(1, key, new IvParameterSpec(salt));
/* 399 */     return cipher.doFinal(plainText.getBytes("UTF-8"));
/*     */   }
/*     */   
/*     */   private static String decrypt(byte[] cipherText, byte[] encryptionKey, byte[] salt) throws Exception {
/* 403 */     MessageDigest md = MessageDigest.getInstance("SHA-256");
/* 404 */     md.update(encryptionKey);
/* 405 */     byte[] rawkey = md.digest();
/* 406 */     System.out.println("sha256 of decryption key: " + new String(DatatypeConverter.printBase64Binary(rawkey)));
/* 407 */     Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding", "SunJCE");
/* 408 */     SecretKeySpec key = new SecretKeySpec(rawkey, "AES");
/* 409 */     cipher.init(2, key, new IvParameterSpec(salt));
/* 410 */     return new String(cipher.doFinal(cipherText), "UTF-8");
/*     */   }
/*     */   
/*     */ 
/* 414 */   public int generateRandomNumber() { return randomGenerator.nextInt(10000); }
/*     */   
/* 416 */   protected static final char[] hexArray = "0123456789ABCDEF".toCharArray();
/*     */   
/* 418 */   public static String bytesToHex(byte[] bytes) { char[] hexChars = new char[bytes.length * 2];
/* 419 */     for (int j = 0; j < bytes.length; j++) {
/* 420 */       int v = bytes[j] & 0xFF;
/* 421 */       hexChars[(j * 2)] = hexArray[(v >>> 4)];
/* 422 */       hexChars[(j * 2 + 1)] = hexArray[(v & 0xF)];
/*     */     }
/* 424 */     return new String(hexChars);
/*     */   }
/*     */   
/* 427 */   public static byte[] getsha256(byte[] input) throws Exception { MessageDigest md = MessageDigest.getInstance("SHA-256");
/* 428 */     md.update(input);
/* 429 */     byte[] sha256 = md.digest();
/* 430 */     return sha256;
/*     */   }
/*     */ }


/* Location:              /Users/stefankofler/Documents/phase4/SourceAndBinary-Team2-Phase3.zip/scs.jar!/MainFrame.class
 * Java compiler version: 7 (51.0)
 * JD-Core Version:       0.7.1
 */