# Create Container
```bash
docker build -t php-self:zts .
```
# Run Container

```bash
docker run -it --rm -v .:/test --entrypoint=bash php-self:zts
```