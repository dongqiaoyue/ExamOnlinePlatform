
#include "Bitree.h"
#include "malloc.h" 
#include "stdio.h"

typedef struct QNode
 {
   TreeNodePtr data;
   struct QNode *next;
 }QNode,*QueuePtr;

 typedef struct
 {
   QueuePtr front,rear;
 }LinkQueue;
 

 int InitQueue(LinkQueue *Q)
 {
   (*Q).front=(*Q).rear=(QueuePtr)malloc(sizeof(QNode));
   if(!(*Q).front)
     return -1;
   (*Q).front->next=NULL;
   return 0;
 }

 int DestroyQueue(LinkQueue *Q)
 {
   while((*Q).front)
   {
     (*Q).rear=(*Q).front->next;
     free((*Q).front);
     (*Q).front=(*Q).rear;
   }
   return 0;
 }

 int ClearQueue(LinkQueue *Q)
 {
   QueuePtr p,q;
   (*Q).rear=(*Q).front;
   p=(*Q).front->next;
   (*Q).front->next=NULL;
   while(p)
   {
     q=p;
     p=p->next;
     free(q);
   }
   return 0;
 }

 int QueueIsEmpty(LinkQueue Q)
 { 
   if(Q.front==Q.rear)
     return 1;
   else
     return 0;
 }

 int GetHead_Q(LinkQueue Q, TreeNodePtr *e)
 {
   QueuePtr p;
   if(Q.front==Q.rear)
     return -1;
   p=Q.front->next;
   *e=p->data;
   return 0;
 }

 int EnQueue(LinkQueue *Q,TreeNodePtr e)
 {
   QueuePtr p=(QueuePtr)malloc(sizeof(QNode));
   if(!p)
     return -1;
   p->data=e;
   p->next=NULL;
   (*Q).rear->next=p;
   (*Q).rear=p;
   return 0;
 }

 int DeQueue(LinkQueue *Q,TreeNodePtr *e)
 {
   QueuePtr p;
   if((*Q).front==(*Q).rear)
     return -1;
   p=(*Q).front->next;
   *e=p->data;
   (*Q).front->next=p->next;
   if((*Q).rear==p)
     (*Q).rear=(*Q).front;
   free(p);
   return 0;
 }

