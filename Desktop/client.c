#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include<unistd.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<netinet/in.h>
#include <netdb.h>

void error(const char *msg){
    perror(msg);
    exit(0);
}
int main(int argc ,char *argv[]){
 int sockfd , portno , n;
 struct sockaddr_in serv_addr;
 struct hostent *server;

 char buffer[255];
 if (argc < 3){
     fprintf(stderr,"usage %s hostname port\n" , argv[0]);
     exit(1);
 }   
 portno = atoi(argv[2]);
 sockfd = socket(AF_INET , SOCK_STREAM ,0);
    if(sockfd<0)
        error("error opening socket");
    server = gethostbyname(argv[1]);
    if(server == NULL){
fprintf(stderr , "error,no such host");
    }    
bzero((char *) &serv_addr , sizeof(serv_addr));
serv_addr.sin_family = AF_INET;
bcopy((char *) server->h_addr , (char *)&serv_addr.sin_addr.s_addr , server->h_length);
serv_addr.sin_port = htons(portno);
if(connect(sockfd , (struct sockaddr *)&serv_addr,sizeof(serv_addr))<0)
error("Conection failed");
bzero(buffer,255);
  
    
    char name[255];
    char gender[255];
    char cat[255];
    char choice[255];
    char apl[255];
    char txt[] =".txt";
    char uname[255];
    char c;
    int words=0;
    FILE *f;
    printf("Enter your username: ");
    scanf("%s",uname);
    write(sockfd,uname,255);  
    scanf("%s %s", choice,name);
    write(sockfd, choice, 255);   						
    write(sockfd, name, 255);
    if(strcmp(choice,"addpatient")!=0){
    printf("command not found!!\n");
    goto q;}
    if(strstr(name,txt)){
     		printf("its a file\n");
     		f=fopen(name,"r");
     		for( words=0;(c=getc(f))!=EOF;words++){}
     		printf("size:%d",words);
     		write(sockfd, &words, sizeof(int));
     		rewind(f);
    		fread(buffer,sizeof(char),512,f);
       	write(sockfd,buffer,512);
       	printf("%s",buffer);
	printf("The file was sent successfully\n");
	goto q;
     		}						
    scanf("%s %s",gender,cat);
    write(sockfd,gender,255);
    write(sockfd,cat,255); 
    scanf("%s",apl);
    write(sockfd,apl,255);
    
q:
close(sockfd);
return 0;



}
