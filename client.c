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
 int sockfd , portno , n, newsockfd;
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
    char district[255];
    char temp[255];
    char c;
    int find_result = 0;
    int words=0;
    int count;
    FILE *f;
    printf("Enter your username: ");
    scanf("%s",uname);
    write(sockfd,uname,255); 
    printf("Enter your district: ");
    scanf("%s ",district); 
    write(sockfd,district,255);
    scanf("%s", choice);
    if (strcmp(choice,"Check_status")==0){
    write(sockfd, choice, 255);
    read(sockfd,&count,255);
     printf("the file has %d case(s) \n", count);
    
    goto q;
    
    }
    else if(strcmp(choice,"search")==0){
    write(sockfd,choice,255);
    scanf("%s",name);
    write(sockfd,name,255);
    read(sockfd,&find_result,255);
    printf("%d matches\n",find_result);
    for(int i=0;i<find_result;i++){
    read(sockfd, temp, 255);
    printf("%s ",temp);
    printf("read");
    }
    goto q;
    }
    else
    write(sockfd, choice, 255); 
    scanf("%s",name);  						
    write(sockfd, name, 255);
    
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
