
## About Accounting Anggaran

Role:

- administrator
- admin
- finance
- tax
- accounting
- team_leader
- staf

Permission:
- (TC) transaction_create
- (TA) transaction_approval
- (TCA) transaction_cancel_approval
- (TET) transaction_edit_tax
- (TEC) transaction_edit_coa
- (TEM) transaction_edit_method
- (TPP) transaction_push_plugin
- (TXC) tax_create
- (TXE) tax_edit
- (TXD) tax_delete
- (CC) company_create
- (CE) company_edit
- (CD) company_delete
- (CSA) company_set_admin
- (CCP) company_connect_plugin
- (PC) project_create
- (PE) project_edit
- (PD) project_delete
- (PAU) project_add_user
- (PAL) project_add_leader
- (UC) user_create
- (UE) user_edit
- (UD) user_delete
- (UR) user_role

## Role and Permission

Administrator
- ALL
- TPP
- transaction_push_plugin

Admin
- TC, UC, UE, UD, UR, PAS, CC, CE, CD, CSA, CCP, PC, PE, PD, PAL, PAU
- User module and assign user to project
- Company module, Project Module

Finance
- TC, TA, TCA, TEM
- transaction_approval, transaction_cancel_approval, transaction_edit_method, 

Tax
- TC, TA, TXC, TXE, TXD, TET
- transaction_approval, tax module, transaction_edit_tax

Accounting
- TC, TA, TEC
- transaction_approval, transaction_edit_coa

Team Leader
- TC, TA
- transaction_approval

Staff
- TC


DB Seeder
- cashflows
- coa_categories
- coa_postings
- coas ()


Note:
- cash & bank diambil dari nama ketagori coa Kas, Bank dan Hutang Bank & Lembaga Keuangan
- default coa untuk contact, sale_account_id (account receivable) => 1.1.03 Account Receivable
- default coa untuk contact, purchase_account_id (account payable) => 2.0.00 Account Payable
- default coa untuk discount/komisi => 1.1.03 Account Receivable => 511100 Commission  